# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

- **Customers (pelanggan):** browse the perfume catalog, search, add to cart, check out (COD / bank transfer), view purchase history, edit their profile. Indonesian-speaking, mobile-heavy usage.
- **Admin/staff:** manage the product catalog, customer & staff accounts, order payment status, and customer contact messages, from a desktop-oriented back office.

## Product Purpose

TGN Parfume is a small Indonesian online perfume shop (e-commerce). It is a Laravel re-implementation of a legacy PHP site; success means customers can complete purchases and admins can run the catalog and orders without touching a database shell.

## Operating Context

- Runs on Laravel + MongoDB (local Docker MongoDB during development; the legacy remote Atlas cluster is unreachable and its credentials retired).
- Legacy `.php` URL aliases must keep working (automated tests enforce the 50-endpoint route map).
- The visual parity constraint with the legacy templates has been **explicitly released by the product owner (2026-11): UX improvements win over pixel parity.** Route-level parity still binds; visual parity does not.

## Capabilities and Constraints

- 50 mapped routes (storefront + admin), covered by a 46-test PHPUnit suite that must stay green.
- Storefront uses the Yummy Bootstrap 5 theme; admin uses the NiceAdmin shell with a custom dark theme (purple/gold gradients). Both are server-rendered Blade with vanilla JS — no SPA framework, and none should be introduced for this effort.
- All UI copy is Indonesian (Bahasa Indonesia); keep it.
- Auth is session-based; roles distinguished by user `level` (customer vs Customer Service/admin); destructive admin actions are protected and must stay protected in any modal refactor.
- Destructive actions currently use native `confirm()` dialogs and admin product create/edit are full-page forms — the owner wants these converted to Bootstrap modal forms.

## Brand Commitments

- Name: **TGN Parfume**.
- Storefront keeps the Yummy theme identity; admin keeps the dark NiceAdmin-based identity.
- Currency format: `Rp 75.000` (Indonesian formatting).

## Evidence on Hand

- 12 seeded products, demo users (admin + customers), one merged legacy employee account.
- 46 green tests; parity docs in `docs/` describe the legacy behavior maps (route truth, not visual truth).
- No real product photography beyond the 12 seeded images in `public/uploaded_img/`; do not fabricate customer testimonials or reviews.

## Product Principles

1. Route parity is law; visual parity is history.
2. Server-rendered Blade + Bootstrap first; zero new JS frameworks.
3. Indonesian copy everywhere; numbers formatted for Indonesia.
4. Destructive actions stay guarded — modals must not weaken authorization or CSRF.
5. The 46-test suite stays green through any UI refactor.

## Accessibility & Inclusion

No standard is contractually required; aim for solid Bootstrap-level accessibility (labels, focus management in modals, visible states) without gold-plating.
