# DESIGN.md — TGN Parfume

Durable visual decisions for this codebase. PRODUCT.md owns product truth; this file
owns the visual world. Schema: `impeccable:design-schema 1`.

## Two identities, one theme layer

The app intentionally runs **two template identities** side by side:

1. **Yummy storefront** (`layouts.app` + `public/assets/css/main.css`) — light,
   warm, Amatic SC display type. Used by: home, cart, checkout, orders, profile,
   product detail.
2. **NiceAdmin dark panel** (`layouts.admin` + `public/Admin/assets/css/style.css`)
   — sidebar/header stay light; `#main` content is dark via `body.tgn-admin`.

Several storefront sub-pages (catalog, search, contact, about, auth) were authored
against a **dark ground** — white headings, slate body text, violet/pink gradient
CTAs. They render inside the light Yummy shell, so they carry their own dark canvas.

## The shared theme layer — `public/css/tgn-theme.css`

Loaded by **both** layouts after their template CSS. It defines the custom class
layer the Blade views rely on (`stat-card`, `glass-card`, `btn-gradient`,
`text-slate-*`, `text-pink-400`, `bg-purple-900`, `text-xs`, `fw-extrabold`,
`gradient-custom-3`, `hover-zoom`, `btn-outline-custom`, `.empty`,
`font-heading`) — none of these exist in either template CSS.

- **Dark canvases:** `.tgn-dark-canvas` (storefront sub-routes, applied by the
  route conditional in `layouts.app` — list is explicit there) and
  `.tgn-admin #main` (admin content only).
- **Palette:** warm charcoal canvases (`#16120e`/`#201a14`), stone neutral text
  (`#e7e5e4`/`#a8a29e`). Accents are brand-derived and context-scoped:
  **gold** `#9B7A3E → #F3A459` (NiceAdmin family, TGN logo gold) owns the admin
  panel; **TGN red** `#aa0000` owns the storefront (CTA gradients, links, focus
  rings); gold `#e3b04b` is the shared premium accent for prices on both.
  Inside dark contexts bootstrap tokens are aligned: `--bs-warning` → gold,
  `--bs-primary` → context accent, so `text-warning`/`text-primary`/badges stay
  on-brand. Semantic `success`/`danger` keep bootstrap defaults.
- **CTA:** `.btn-gradient` uses the context gradient (admin gold, storefront red)
  with white text; never use gradient text (headings use solid `.text-accent`
  accents instead). Category badges: `.badge-category` (gold, male),
  `.badge-female` (red, female).
- **Accent class:** use `.text-accent` (context accent) / `.text-gold` for
  premium highlights. Do not introduce blue, cyan, pink, or violet accents.

Do not use these classes without this file loaded; do not define them elsewhere.

## Icons

**Bootstrap Icons (`bi-*`) only.** Both layouts load `bootstrap-icons.css`;
FontAwesome was never loaded anywhere, so all legacy `fa-*` classes were migrated
to `bi-*`. Never reintroduce `fa-*` classes.

## Shared behavior — `public/js/tgn-ui.js`

Vanilla JS + Bootstrap 5, included by both layouts. Owns: flash toasts
(`partials/toasts.blade.php`, reads `session('success')/('error')`), destructive
confirmations (`partials/confirm-modal.blade.php`; dark variant on admin — any
`<form data-confirm data-confirm-title=… data-confirm-text=… data-confirm-accept=…>`
opens it), viewer/hydration modals (`data-view-target` + `data-fill`), and the
product create/edit modal mode switch (create/edit share one form on the products
index; failed validation reopens it via `session('form_mode')`/`form_id` and body
`data-reopen-*` attributes). Order status selects use `data-cancel-confirm="1"`
to confirm a Cancel and restore the previous value on dismiss.

## Interaction patterns

- **CRUD lives in modals** on index pages (product create/edit is the pattern;
  detail views use viewer modals — messages, orders). Checkout, auth, and cart
  remain full pages by product decision.
- **Copy is Indonesian.**
- Buttons for destructive actions: `btn-outline-danger`; confirm accept: `btn-danger`.
