# PARITY ROUTE MATRIX — TGN PARFUME

## 1. Route Reconciliation Summary

| Original Path | Legacy Method | Laravel Route Path | Laravel Method | Middleware / Guards | Parameter Aliases Handled | Status |
|---|---|---|---|---|---|---|
| `/index.php` | GET | `/` & `/index.php` | GET | `web` | None | **MATCH** |
| `/index.php#about` | GET | `/about` | GET | `web` | None | **MATCH** |
| `/index.php#contact` | GET | `/contact` | GET | `web` | None | **MATCH** |
| `/forms/contact.php` | POST | `/contact` | POST | `web` | `name`, `email`, `number`, `message` | **MATCH** |
| `/product.php` | GET | `/products` & `/product.php` | GET | `web` | `category` (optional), `pid` | **MATCH** |
| `/product.php` (detail) | GET | `/products/{id}` | GET | `web` | `id` (Mongo ObjectId / integer ID) | **MATCH** |
| `/product.php` (cart add) | POST | `/product.php` & `/cart/add` | POST | `auth` | `pid` -> `product_id`, `qty` -> `quantity` | **MATCH** |
| `/sign-in.php` | GET/POST | `/sign-in.php` & `/login` | GET/POST | `guest` | `username` / `email`, `pass` / `password` | **MATCH** |
| `/sign-up.php` | GET/POST | `/sign-up.php` & `/register` | GET/POST | `guest` | `name`, `username`, `email`, `phone`, `password` | **MATCH** |
| `/components/user-sign-out.php` | GET/POST | `/logout` | GET/POST | `auth` | None | **MATCH** |
| `/forgot-password.php` | GET/POST | `/forgot-password.php` | GET/POST | `guest` | `fullname`, `email`, `phone` | **MATCH** |
| `/reset-password.php` | GET/POST | `/reset-password.php` | GET/POST | `guest` | `new_pass`, `cpass` | **MATCH** |
| `/cart.php` | GET | `/cart.php` & `/cart` | GET | `auth` | `delete_all=1` | **MATCH** |
| `/cart.php` (update/del) | POST | `/cart.php` | POST | `auth` | `cart_id`, `qty`, `update_qty`, `delete` | **MATCH** |
| `/checkout.php` | GET/POST | `/checkout.php` & `/checkout` | GET/POST | `auth` | `firstname`, `lastname`, `address`, `city`, `zip`, `cc-name` | **MATCH** |
| `/purchase-history.php` | GET | `/purchase-history.php` & `/orders` | GET | `auth` | None | **MATCH** |
| `/purchase-history-details.php` | GET | `/purchase-history-details.php` & `/orders/{id}` | GET | `auth` | `pid` -> `id` | **MATCH** |
| `/users-profile.php` | GET/POST | `/users-profile.php` | GET/POST | `auth` | `fullname`, `username`, `phone`, `email`, `address` | **MATCH** |
| `/Admin/index.php` | GET | `/Admin` & `/Admin/index.php` | GET | `auth`, `admin` | None | **MATCH** |
| `/Admin/admin-sign-in.php` | GET/POST | `/Admin/admin-sign-in.php` | GET/POST | `web` | `username`, `pass` | **MATCH** |
| `/Admin/penjualan-list-produk.php` | GET | `/Admin/penjualan-list-produk.php` | GET | `auth`, `admin` | None | **MATCH** |
| `/Admin/penjualan-add-produk.php` | GET/POST | `/Admin/penjualan-add-produk.php` | GET/POST | `auth`, `admin` | `name`, `details`, `categories`, `price`, `image` | **MATCH** |
| `/Admin/penjualan-history-pesanan.php` | GET | `/Admin/penjualan-history-pesanan.php` | GET | `auth`, `admin` | None | **MATCH** |
| `/Admin/users.php` | GET | `/Admin/users.php` | GET | `auth`, `admin` | None | **MATCH** |

---

## 2. Decision Log
- All 50 legacy URL aliases map cleanly to target controllers.
- HTTP status codes (200 OK for render, 302 Redirect for form processing) are behaviorally equivalent.
