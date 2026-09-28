# Feature: Product Details — Image Zoom, Quantity Stepper, Dev Entry Route

## Objective

1. `http://localhost:3000/` must start the app when running `php -S localhost:3000`
   (today it 404s because the root `index.php` was renamed to `pages/index.php`).
2. Hover-lens zoom (Amazon-style) over the main product image on the details page.
3. Increase/decrease quantity stepper on the details page that adds N units of the
   same product to the cart.

## Problem / Why

- After commit `d0c2581` the repo root has no `index.php`, so the PHP built-in server
  returns 404 at `/`; the user must type `/pages/index.php` manually.
- `pages/catalog/productDetails.php` shows a plain `<img id="productimage">` with no
  way to inspect the product image up close.
- The quantity field on the details page is decorative: `<input type="text" placeholder="1">`
  is never sent; `iniciate_buy()` POSTs only `code_prod`, and `backend/auth/verify_login-buy.php`
  inserts exactly one `ORDERS` row per click.

## Key decisions

- **Entry route**: root `index.php` issues `Location: /pages/index.php` redirect (NOT
  `require`) so the browser URL becomes `/pages/index.php` and every existing
  root-absolute link (`/css/...`, `/js/...`, `/images/...`) keeps resolving exactly as
  today. Server command stays `php -S localhost:3000` (no router arg).
- **Zoom style**: user chose hover lens (Amazon-style) over click-overlay. Lens follows
  the cursor on `#productimage`; preview panel shows the zoomed region (~200%).
  Desktop-hover interaction; no new CDN dependencies (vanilla JS or existing jQuery).
- **Quantity semantics**: `ORDERS` has no quantity column and the cart
  (`backend/order/get_all_orders.php`) renders one line per row. Adding N units inserts
  N rows via a single multi-row `INSERT ... VALUES (...),(...)`. No DB schema changes.
  Known consequence: cart lists N lines for N units (math/count stays correct).
- **Bounds**: quantity clamped to integers 1..99 (default 1 on missing/invalid input).

## Scope

**In:**

1. T1 — root `index.php` redirect to `/pages/index.php`.
2. T2 — quantity stepper UI in `productDetails.php`, send `quantity` in
   `iniciate_buy()`, multi-row insert + validation in `verify_login-buy.php`.
3. T3 — hover-lens zoom on `#productimage` (JS on the page + styles appended to
   `css/styles.css`, dark-mode friendly).

**Out:** cart page changes, DB migrations, thumbnail gallery (the 4 static thumbnails
stay as-is), overlay/click zoom, push/PR.

## Constraints

- Only these files: `index.php` (new), `pages/catalog/productDetails.php`,
  `backend/auth/verify_login-buy.php`, `css/styles.css`.
- All generated UI copy/comments in English; no AI attribution.
- TDD off (no test runner in repo); checks = `php -l` + `node --check` + read-back.
- MySQL not provisioned → no runtime DB verification (report honestly).
- Commits: local only, no push (user decision from previous feature still in force).

## Checks / Verification

- `php -l` on root `index.php`, `pages/catalog/productDetails.php`,
  `backend/auth/verify_login-buy.php`.
- `node --check` on any extracted/added JS.
- Structural read-back of CSS additions (append-only at end of `styles.css`).
- Redirect smoke test: start `php -S localhost:3000`, request `/`, expect
  `302 Location: /pages/index.php` (no DB needed for the redirect itself).

## Route declarations

- Mapping: CodeGraph initialized (`.codegraph/` was missing) but PHP indexing shallow →
  fallback to direct reads (3 files: productDetails.php, verify_login-buy.php,
  get_all_orders.php).
- Implementation: delegated-direct single writer (writer trigger: 4 non-trivial files).
- Verification: writer runs checks; parent spot-checks + commit + RDD assess.

## Progress log

- [x] T1 entry redirect — root `index.php` (302 → `/pages/index.php`)
- [x] T2 quantity stepper — `.qty-stepper` + clamp 1..99 frontend; backend
      intval(code_prod) [SQLi fix] + N-tuple multi-row INSERT, detail
      "Added N unit(s) to cart"; not-logged path preserved
- [x] T3 hover-lens zoom — lens 120px + preview 300px, zoom 2×, object-fit:contain
      content-rect math, MutationObserver hides on src change, body.dark variants
- [x] Checks: `php -l` clean ×3 (parent re-ran verify_login-buy.php spot check);
      extracted inline JS → `node --check` exit 0; CSS appended at 2084–2190, no
      existing rules modified; redirect smoke test live: `302 Location: /pages/index.php`
      (port 3999, server killed). NOT verified: DB runtime + real-browser hover
      (MySQL not provisioned).
- [x] Delegated writer (general, skill frontend-design paths-injected) returned success.
- [x] Work-unit commit `5ff93d3` "feat: add product details zoom, quantity stepper,
      and dev entry route" (6 files, +382/−8, local — no push; `.codegraph/` excluded).
- [x] Post-commit RDD assess: first attempt `unassessable` (untracked needs declaration)
      → re-ran with `--untracked-scope=exclude` + inventory → `high` (hot_path
      `backend/auth/verify_login-buy.php`), `review_due` → preflight (consolidated
      branch candidate sha256:ef9d13a2..., 66 files/12383 lines) → consent relayed →
      user chose "Skip this time" → `declined` / `declined_this_candidate`. No review
      record; ordinary repo policy governs delivery.
- [x] Delivery report sent to the user.
- Follow-up noted: `$_SESSION['code_user']` still raw-interpolated in the same SQL
  (out of authorized scope this round).
