# Feature: Catalog UX Improvements

## Objective

Fix empty-query search behavior (no navigation, no wasted request), style the nav search
input, implement real pagination on the products catalog, persist the user's light/dark
theme across page changes and reloads, and introduce SweetAlert-based notifications
replacing native `alert()` calls.

## Problem / Why

- `js/search.js` navigates to `results.php?text=<value>` on Enter/icon click even with an
  empty query; `pages/catalog/results.php` then always fires an AJAX call whose
  `LIKE '%%'` matches every product — an unnecessary request that returns the full table.
- The nav search input (`.search_text` in `backend/layouts/_nav.php`) has ZERO CSS rules
  in `css/styles.css` — it renders as a bare browser-default text box next to a bare icon.
- `pages/catalog/products.php` renders a static, dead pagination block (`1 2 ›› Last »`)
  with no handlers; `backend/product/get_all_products.php` returns ALL rows (no
  LIMIT/OFFSET, no total), so page navigation is impossible.
- `js/dark.js` toggles `body.dark` but persists nothing, and no code re-applies the theme
  on load — the theme is lost on every navigation/reload.
- No SweetAlert anywhere; UX uses blocking native `alert()` in cart, contact, and
  product-details flows.

## Scope

**In:**

1. T1 — SweetAlert2 notifications infrastructure (CDN + shared helper + load order).
2. T2 — Empty-query search guard (nav search + results page request skip + query escaping).
3. T3 — Search input UI restyle (grouped input+icon, focus states, dark-mode variant).
4. T4 — Real pagination for `pages/catalog/products.php` (backend LIMIT/OFFSET + totals,
   dynamic controls, category/page interplay), including de-duplicating the 6 copy-pasted
   AJAX blocks into one loader.
5. T5 — Theme persistence (localStorage + apply-on-load before paint, logo handling).
6. T6 — Replace native `alert()` calls with the SweetAlert helper.

**Out:**

- No schema/migration changes, no framework introduction, no build tooling.
- No changes to auth, orders, or payment logic beyond swapping alert calls.
- No commit/push: the working tree carries an in-progress, partially-staged refactor
  (renames under `pages/`, `backend/`, `css/`); commits require an explicit user decision
  so unrelated staged work is never swept in.
- SQL-injection hardening of pre-existing raw queries is out of scope except where the
  touched code already interpolates user input (search text) — escaping applied there.

## Constraints

- Plain PHP 8.2 + jQuery 3.3.1 + vanilla JS; CDN libraries allowed (project already uses
  CDNs: jQuery, Font Awesome, Glide, AOS).
- Keep existing design tokens (`:root` CSS variables) and layout classes.
- All pages that matter include `backend/layouts/_nav.php` (body start) and
  `backend/layouts/_footer.php` (after content, before page-level scripts) — shared
  script/theme hooks live there. `signin.php`/`signup.php` include neither and need no
  notifications/search/theme changes.
- Generated artifacts (code, UI copy) in English regardless of conversation language.
- Advisory planning heuristic only: ~400 authored changed lines per task; no size-only
  rework, tests/docs stay with behavior.

## Decisions (recorded, not user-blocking)

- **Page size:** 12 products/page (3-column catalog grid → 4 rows).
- **Empty search:** no navigation and no request; show a SweetAlert warning toast and
  keep focus in the input. Results page with a blank/missing `text` param skips the AJAX
  call and shows an empty-state message instead of loading all products.
- **Pagination scope:** `charge` category filter preserved exactly as-is; page resets to 1
  on category change.

## Tasks

- [x] T1 Notifications infra — SweetAlert2 CDN + `js/notifications.js` helpers
      (`notifySuccess/notifyError/notifyWarning/notifyInfo`, native-alert fallback),
      included from `_footer.php` before page scripts. (verified: `node --check` exit 0,
      footer read-back OK)
- [x] T2 Empty-query guard — `search.js` trims/blocks empty (uses T1 toast), encodes the
      query, icon click no longer follows `#`; `results.php` skips AJAX on blank query,
      escapes `$_GET['text']` for HTML and JS contexts. (verified: `node --check`,
      `php -l` both clean; hardening: `is_string` guard against `?text[]=x` fatal,
      `JSON_HEX_*` flags against script-tag breakout)
- [x] T3 Search input UI — `.search-box` group markup in `_nav.php`; CSS for input,
      icon, focus ring, hover, dark-mode; responsive behavior.
      (verified: `php -l` nav clean, styles.css read-back OK)
- [x] T4 Pagination — backend returns `total`/`page`/`per_page`/`total_pages` with
      LIMIT/OFFSET; `products.php` gets one `loadProducts()` loader + dynamic
      prev/numbers/next controls + active state; category change resets to page 1.
      (verified: `php -l` both clean; inline JS `node --check` exit 0; 5 window cases
      computed by the extracted function; clamp trace harness: offset 0/24/24-clamped;
      CRITICAL catch: `productDetails.php` is a second consumer of the endpoint scanning
      ALL rows — pagination made OPT-IN via `per_page` so legacy full-fetch is preserved;
      6 duplicated ajax blocks deduplicated into `buildProductCard` + `loadProducts`;
      ORDER BY `code_prod ASC` added for stable page boundaries)
- [x] T5 Theme persistence — `_nav.php` inline apply-on-load (body class, switch state,
      logo) from `localStorage['sellbuy-theme']`; `dark.js` toggle persists + explicit
      logo swap (replaces fragile src-match toggle). (verified: `php -l` nav clean,
      `node --check dark.js` exit 0; bonus fix: dark.js no longer crashes on pages
      without #switch)
- [x] T6 Alert replacement — `cart.php` (5), `Contact.php` (2), `productDetails.php` (2)
      native alerts → SweetAlert helpers with appropriate icons. (verified: 9
      notify* call sites confirmed by grep, 0 live `alert(` left in pages/,
      `php -l` ×3 clean; copy fix: "Message Sended Succefully" → "Message sent
      successfully")

## Acceptance criteria

- Enter / icon click with an empty or whitespace-only query performs NO navigation and
  shows a warning toast; a non-empty query navigates with proper URL encoding.
- `results.php` with a blank query fires no backend request and displays an empty state;
  the query string is HTML- and JS-escaped in output.
- Nav search input is visually styled (pill shape, padding, focus ring, hover) in both
  light and dark themes.
- Products page shows working pagination: correct slice per page, total pages from real
  counts, active page highlighted, prev/next/last work, category switch resets to page 1.
- Theme survives navigation and reload (no flash of wrong theme from nav paint onward);
  logo matches theme.
- Cart/contact/product-details user feedback uses SweetAlert toasts/modals instead of
  native `alert()`.

## Checks / Verification

- `php -l` on every edited `.php` file.
- `node --check` on every edited `.js` file.
- Structural read-back of each edited file (this is a no-test-framework legacy project;
  TDD off — no test runner exists in repo).
- Runtime check against MySQL via docker-compose is NOT part of this run (environment
  not provisioned); noted honestly as unverified at runtime.

## Route declarations

- Mapping: inline exploration (Task delegation attempted; provider returned
  "free tier can only be used from within OpenCode" — fallback to direct reads).
- Implementation: delegated-direct writer attempted per writer trigger (2+ non-trivial
  files); falls back to direct inline if the provider is unavailable again.
- Verification: parent readback + syntax checks (RDD status read at delivery time).

## Progress log

- [x] Exploration complete (search flow, pagination, theme, notification candidates).
- [x] T1..T6 implemented (T1–T4 via delegated writers, micro-hardening + comment fixes
      inline; T5–T6 via delegated writer).
- [x] Checks run: `php -l` clean on all 8 edited PHP files; `node --check` clean on
      search.js, dark.js, notifications.js; inline products script extracted +
      `node --check` exit 0; pagination window verified against 5 computed cases;
      clamp trace harness OK; grep confirms 0 live `alert()` in pages/.
      NOT verified: runtime against MySQL (environment not provisioned).
- [x] Native review (RDD on): untracked selection submitted (js/notifications.js + this
      doc; `.atl/` excluded); START frozen on target sha256:bb80a55b... (63 files /
      11947 lines — candidate includes the in-progress refactor). Consent relayed →
      user chose "Skip this time" → `declined` / `declined_this_candidate`. No review
      record created; ordinary repo policy governs delivery.
- [ ] Delivery report + commit decision with user (report delivered; commit decision
      pending — tree mixes staged refactor renames with my edits).
