# PARITY VISUAL REGRESSION REPORT — TGN PARFUME

## 1. Environment & Engine Configuration

- **Engine**: Playwright Chromium Headless + Pixelmatch Engine
- **Legacy Server Target**: `http://127.0.0.1:8080`
- **Laravel Server Target**: `http://127.0.0.1:8000`
- **Execution Date**: 2026-09-07T05:08:15.733Z

---

## 2. Screenshot Evidence & Comparison Summary

| Page ID | Viewport | Legacy Endpoint | Laravel Endpoint | Differing Pixels | Mismatch % | Status |
|---|---|---|---|---|---|---|
| `home` | 1440x900 (desktop) | `/index.php` | `/index.php` | 115 px | 0.01% | **PASS** |
| `about` | 1440x900 (desktop) | `/index.php#about` | `/index.php#about` | 56883 px | 4.39% | **REVIEW** |
| `contact` | 1440x900 (desktop) | `/index.php#contact` | `/index.php#contact` | 732 px | 0.06% | **MINOR** |
| `products` | 1440x900 (desktop) | `/product.php?pid=1` | `/product.php?pid=1` | 103902 px | 8.02% | **REVIEW** |
| `product_detail` | 1440x900 (desktop) | `/product.php?pid=1` | `/product.php?pid=1` | 103902 px | 8.02% | **REVIEW** |
| `login` | 1440x900 (desktop) | `/sign-in.php` | `/sign-in.php` | 1719 px | 0.13% | **MINOR** |
| `forgot_password` | 1440x900 (desktop) | `/forgot-password.php` | `/forgot-password.php` | 0 px | 0% | **PASS** |
| `reset_password` | 1440x900 (desktop) | `/reset-password.php` | `/reset-password.php` | 0 px | 0% | **PASS** |
| `cart` | 1440x900 (desktop) | `/cart.php` | `/cart.php` | 213222 px | 16.45% | **REVIEW** |
| `checkout` | 1440x900 (desktop) | `/checkout.php` | `/checkout.php` | 209367 px | 16.15% | **REVIEW** |
| `order_history` | 1440x900 (desktop) | `/purchase-history.php` | `/purchase-history.php` | 506179 px | 39.06% | **REVIEW** |
| `profile` | 1440x900 (desktop) | `/users-profile.php` | `/users-profile.php` | 163225 px | 12.59% | **REVIEW** |
| `admin_dashboard` | 1440x900 (desktop) | `/Admin/index.php` | `/Admin/index.php` | 29041 px | 2.24% | **REVIEW** |
| `admin_products` | 1440x900 (desktop) | `/Admin/penjualan-list-produk.php` | `/Admin/penjualan-list-produk.php` | 806247 px | 62.21% | **REVIEW** |
| `admin_orders` | 1440x900 (desktop) | `/Admin/penjualan-history-pesanan.php` | `/Admin/penjualan-history-pesanan.php` | 18141 px | 1.4% | **REVIEW** |
| `admin_users` | 1440x900 (desktop) | `/Admin/users.php` | `/Admin/users.php` | 321388 px | 24.8% | **REVIEW** |
| `home` | 375x812 (mobile) | `/index.php` | `/index.php` | 84 px | 0.03% | **PASS** |
| `about` | 375x812 (mobile) | `/index.php#about` | `/index.php#about` | 0 px | 0% | **PASS** |
| `contact` | 375x812 (mobile) | `/index.php#contact` | `/index.php#contact` | 7350 px | 2.41% | **REVIEW** |
| `products` | 375x812 (mobile) | `/product.php?pid=1` | `/product.php?pid=1` | 34531 px | 11.34% | **REVIEW** |
| `product_detail` | 375x812 (mobile) | `/product.php?pid=1` | `/product.php?pid=1` | 34531 px | 11.34% | **REVIEW** |
| `login` | 375x812 (mobile) | `/sign-in.php` | `/sign-in.php` | 619 px | 0.2% | **MINOR** |
| `forgot_password` | 375x812 (mobile) | `/forgot-password.php` | `/forgot-password.php` | 1320 px | 0.43% | **MINOR** |
| `reset_password` | 375x812 (mobile) | `/reset-password.php` | `/reset-password.php` | 0 px | 0% | **PASS** |
| `cart` | 375x812 (mobile) | `/cart.php` | `/cart.php` | 48177 px | 15.82% | **REVIEW** |
| `checkout` | 375x812 (mobile) | `/checkout.php` | `/checkout.php` | 48177 px | 15.82% | **REVIEW** |
| `order_history` | 375x812 (mobile) | `/purchase-history.php` | `/purchase-history.php` | 129017 px | 42.37% | **REVIEW** |
| `profile` | 375x812 (mobile) | `/users-profile.php` | `/users-profile.php` | 41745 px | 13.71% | **REVIEW** |
| `admin_dashboard` | 375x812 (mobile) | `/Admin/index.php` | `/Admin/index.php` | 16675 px | 5.48% | **REVIEW** |
| `admin_products` | 375x812 (mobile) | `/Admin/penjualan-list-produk.php` | `/Admin/penjualan-list-produk.php` | 204596 px | 67.19% | **REVIEW** |
| `admin_orders` | 375x812 (mobile) | `/Admin/penjualan-history-pesanan.php` | `/Admin/penjualan-history-pesanan.php` | 13977 px | 4.59% | **REVIEW** |
| `admin_users` | 375x812 (mobile) | `/Admin/users.php` | `/Admin/users.php` | 123423 px | 40.53% | **REVIEW** |

---

## 3. Visual Triage Summary

- **Total Pages Captured**: 32
- **Exact Visual Structure PASS**: 6
- **MINOR (Antialiasing/Font Diff <=1.0%)**: 4
- **REVIEW / Discrepancy Held**: 22

## 4. Final Visual Decision

# **PARITY NOT YET VERIFIED**
*(22 items held at REVIEW for visual asset/dynamic rendering verification).*