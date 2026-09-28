# Feature: Profile Address + Edit Profile + Mercado Pago Checkout

## Objective

1. **DB/address**: the user profile stores a delivery address (and phone) so products
   can reach the buyer; checkout uses it.
2. **Edit profile**: full profile editing (name, second name, optional password, address,
   phone) with prefilled form.
3. **Payments**: Mercado Pago **Checkout Pro (redirect)** wired into checkout so purchases
   can actually be paid.

## Current state (exploration findings, verified)

- `pages/account/userInfo.php` already has a PARTIAL edit form (name, second name,
  password → POST `/backend/user/modifyProfile.php`); no address, not login-gated,
  dead validation code.
- `backend/user/modifyProfile.php`: SQL interpolated raw (SQLi), writes password even
  when input empty, `header(Location)` fires before `echo json` (dead code).
- `backend/user/get_user_info.php`: `SELECT *` → returns **plaintext password to the
  browser**; no address fields (they don't exist).
- Schema (`db/script.sql`, bootstrapped by docker-compose; `db/id17893453_sellbuy.sql`
  is a historical dump — DO NOT TOUCH): `users(code_user, name_user, secondname_user,
  email_user, password_user, state_user)` — **no address/phone**; `orders(...,
  address_order varchar(70), phone_order varchar(15), card_order varchar(20))`.
  **Name collision alert: `users.state_user` already exists (account-active flag) →
  new region column MUST be `region_user`, never `state_user`.**
- No migrations framework; no composer; no .env; no secrets pattern; no MP/gateway
  traces anywhere in the repo.
- Cart = `orders` rows `state_order=1`. **Critical pre-existing bugs:**
  - `backend/order/to_process.php` (cart feed) has NO `code_user` filter → shows ALL
    users' pending orders.
  - `backend/order/confirm.php` updates ALL users' state-1 rows (reads `$code_user`
    but never uses it in WHERE).
  - `backend/order/get_processed.php` (order history feed) has no `code_user` filter.
  - `pages/checkout/order.php` total loop uses `parseFLoat` (typo → ReferenceError,
    total display broken).
  These MUST be fixed: MP and per-user checkout cannot work on top of them.
- State machine: 1=in cart, 2=To Pay (transfer path), 3=To Deliver (paid),
  4/5 labeled but never written.
- Session keys: `code_user`, `email_user`, `name_user` (set in `backend/auth/login.php`).
- Connection: `backend/_conection.php` → localhost/root/1234/sellbuy_php_db.
  Docker + docker-compose (3306) present; `mysql` CLI NOT on PATH; live container state
  unknown at time of writing.

## Key decisions

- **MP flow**: user chose **Checkout Pro (redirect)** — server creates a preference via
  plain REST (`curl`, NO composer/SDK) and redirects to `init_point`.
- **Credentials**: `backend/_payment_config.php` (real values, **gitignored**) +
  committed `backend/_payment_config.sample.php` template; `MP_ACCESS_TOKEN` placeholder
  until the user pastes test/prod token. `MP_CURRENCY_ID` default **MXN** (matches page
  copy "MXN399"), configurable.
- **Paid state**: MP-approved payment → `state_order = 3` (To Deliver). Manual/transfer
  path (pay_type radios → confirm.php) unchanged → still 2.
- **Trust model**: no public URL for webhooks in local dev → the success `back_url`
  endpoint (`mp_success.php`) re-verifies with the MP API server-side
  (`GET /v1/payments/search?external_reference=…`) before marking paid. Unverifiable →
  `order.php?mp=unverified` (no state change). Documented limitation: no IPN webhook.
- **Address shape (decided, not asked)**: structured columns on `users`:
  `address_user varchar(150)` (street), `city_user varchar(60)`,
  `region_user varchar(60)`, `zip_user varchar(10)`, `country_user varchar(60)`,
  `phone_user varchar(15)`; also `ALTER orders.address_order → varchar(150)` so copies
  don't truncate/fail.
- **Address → orders**: copied into `orders.address_order`/`phone_order` at MP success
  (from profile); the existing cart Address/Phone inputs remain for the manual confirm
  path and get prefilled from profile.
- **Edit-profile scope**: email NOT editable (login identity). Password updated ONLY
  when non-empty; plaintext semantics kept (login compares plaintext — hashing is a
  separate follow-up). Security fixes IN-SCOPE for touched files: stop returning
  `password_user`, SQL-escape the UPDATE, fix header-before-echo, login-gate userInfo.
- **Migration mechanism**: new `db/migrations/001_user_address.sql` + patch
  `db/script.sql` (fresh containers). If the MySQL docker container is running, apply
  the migration live via `docker exec`; otherwise leave instructions — report which.
- **payMethods.php untouched** (static SHEIN boilerplate, out of scope). MP entry =
  button on the cart page.
- **Secrets in .gitignore**: add `backend/_payment_config.php` (+ `.codegraph/` while
  there — local CodeGraph index must never be committed).

## Scope

**In:**

1. T1 — Address/phone DB migration (users + orders widen), script.sql patch, live
   apply if container up.
2. T2 — Profile edit: userInfo form (address fields, prefill, login gate, toast),
   get_user_info contract (`address_user, city_user, region_user, zip_user,
   country_user, phone_user`; NO password_user), modifyProfile rewrite (escape, JSON/
   redirect fix, optional password, new fields).
3. T3 — Checkout correctness: user-scope `to_process`, `confirm`, `get_processed`;
   fix `parseFLoat`; cart prefill address/phone from profile.
4. T4 — MP Checkout Pro: config sample + gitignore, `create_preference.php`
   (session gate, config gate, grouped items from user's state-1 rows, curl POST to
   MP API, init_point out), cart "Pay with Mercado Pago" button, `mp_success.php`
   (verify via MP API → mark state 3 + copy address/phone → redirect),
   order.php result toasts (?mp=success/unverified/cancel).

**Out:** payMethods redesign, password hashing, email editing, IPN webhook (no public
URL), MP marketplace/split payments, push/PR, changes to registration/signup country
selects.

## Constraints

- Files only: as listed in T1–T4 + `.gitignore`. No unrelated edits.
- All generated UI copy/comments in English; no AI attribution.
- TDD off (no runner): checks = `php -l` × touched PHP + `node --check` for touched JS +
  structural read-backs + bounded runtime probes where possible.
- MySQL/MP runtime may be unavailable → report honestly, never fake results.
- Commits: LOCAL only, never push. Two work-unit commits (profile batch, checkout/MP batch).

## Route declarations

- Mapping: delegated read-only exploration (general) — 14 questions, map returned.
- Implementation: two sequential delegated writers (T1+T2 / T3+T4); parent gates +
  commits between batches.
- Verification: writer foreground checks; parent spot-check per batch; RDD assess per
  commit.

## Progress log

- [x] T1 migration + script.sql patch (+ live apply if possible) — applied via
      `docker exec sellbuydb`, post-verified via information_schema (6 new cols,
      `address_order` 150).
- [x] T2 profile edit (userInfo / get_user_info / modifyProfile) — `php -l` clean,
      prepared UPDATE, no password leak, address prefill; parent spot-check passed.
- [x] Commit A: profile + address (local) — `5cb2b1e` (8 files, +277/−60).
      Review consent: declined (`declined_this_candidate`).
- [x] T3 checkout scoping + total fix + prefill — all three WHERE clauses now carry
      `code_user=?` (confirmed in source); `parseFLoat` → `parseFloat` (order.php:222);
      cart Address/Phone prefilled from profile (join non-empty parts, only into empty
      inputs; get_user_info key = `dates`).
- [x] T4 MP Checkout Pro — config sample + gitignored real config; `create_preference.php`
      (session gate → config gate → grouped prepared cart query → curl POST → init_point);
      `mp_success.php` (regex ref validation + ownership + MP `payments/search` re-verify →
      state 3 + address/phone copy → header-only redirects); cart `#payMP` button
      (double-click guard, open_login / notifyError handling); order.php `?mp=` toasts.
      Verified: `php -l` 9/9, `node --check` on extracted inline JS 2/2 (exit 0),
      CLI harness probes (not_logged, empty-token gate, mp_success 0 stdout bytes ×4),
      structural pairings (response keys ↔ JS, `?ref=` producer ↔ consumer, back_urls
      ↔ toasts), live-DB schema + `ONLY_FULL_GROUP_BY` prepared-execute check.
- [x] Commit B: checkout + MP (local) — this commit; sha recorded in delivery report.
- [x] Checks + delivery report — pending only the post-commit RDD assess + final report.
