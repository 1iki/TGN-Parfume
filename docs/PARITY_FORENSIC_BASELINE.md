# PARITY FORENSIC BASELINE — TGN PARFUME

## 1. Machine-Verifiable Forensic Summary

```text
LEGACY ENDPOINT COUNT = 50
LARAVEL ENDPOINT COUNT = 50
MATCHED = 50
MISSING = 0
EXTRA = 0
METHOD MISMATCH = 0
PARAMETER MISMATCH = 0
```

---

## 2. Comprehensive Legacy vs Laravel Endpoint Matrix

| ID | Legacy Source File / Action | Method | Legacy URL / Entry Point | Input / Query Parameters | Expected Behavior | Laravel Target Endpoint | Controller & Method | Target View / Response | Test Case | Status |
|---|---|---|---|---|---|---|---|---|---|---|
| EP-01 | `index.php` | GET | `/` | None | Renders Yummy storefront homepage with 9 sections | `/` | `HomeController@index` | `home.blade.php` | `RouteParityTest` | **PASS** |
| EP-02 | `index.php` | GET | `/index.php` | None | URL alias for homepage | `/index.php` | `HomeController@index` | `home.blade.php` | `RouteParityTest` | **PASS** |
| EP-03 | `index.php#about` | GET | `/about` | None | Renders About section | `/about` | `HomeController@about` | `home.blade.php` | `RouteParityTest` | **PASS** |
| EP-04 | `index.php#contact` | GET | `/contact` | None | Renders Contact section & form | `/contact` | `HomeController@contact` | `home.blade.php` | `RouteParityTest` | **PASS** |
| EP-05 | `forms/contact.php` | POST | `/contact` | `name`, `email`, `number`, `message` | Stores contact message in database | `/contact` | `ContactController@store` | Redirect + Flash message | `MessageParityTest` | **PASS** |
| EP-06 | `index.php#menu` | GET | `/products` | `category` (optional) | Displays products catalog | `/products` | `ProductController@index` | `products/index.blade.php` | `ProductParityTest` | **PASS** |
| EP-07 | `product.php` | GET | `/product.php` | `pid` (optional) | Catalog or single product view | `/product.php` | `ProductController@index` | `products/index.blade.php` / `products/show.blade.php` | `LegacyEndpointParityTest` | **PASS** |
| EP-08 | `product.php` | GET | `/products/{id}` | `id` (Mongo ObjectID or legacy ID) | Displays single product detail view | `/products/{id}` | `ProductController@show` | `products/show.blade.php` | `ProductParityTest` | **PASS** |
| EP-09 | `product.php` | POST | `/product.php` | `pid`, `name`, `price`, `image`, `qty`, `add_to_cart` | Adds product to user cart from product page | `/product.php` | `CartController@add` | Redirect + Flash message | `LegacyEndpointParityTest` | **PASS** |
| EP-10 | `index.php` | GET | `/search` | `search` | Filters products by search query | `/search` | `HomeController@search` | `search.blade.php` | `ProductParityTest` | **PASS** |
| EP-11 | `sign-in.php` | GET | `/sign-in.php` | None | Renders customer sign-in form | `/sign-in.php` | `AuthController@showLogin` | `auth/login.blade.php` | `AuthParityTest` | **PASS** |
| EP-12 | `sign-in.php` | GET | `/login` | None | Standard route for sign-in form | `/login` | `AuthController@showLogin` | `auth/login.blade.php` | `AuthParityTest` | **PASS** |
| EP-13 | `sign-in.php` | POST | `/sign-in.php` | `username`/`email`, `pass`/`password` | Authenticates user & auto-upgrades SHA-1 to Bcrypt | `/sign-in.php` | `AuthController@login` | Redirect to Home / Admin | `AuthParityTest` | **PASS** |
| EP-14 | `sign-in.php` | POST | `/login` | `username`/`email`, `pass`/`password` | Standard POST endpoint for authentication | `/login` | `AuthController@login` | Redirect to Home / Admin | `AuthParityTest` | **PASS** |
| EP-15 | `sign-up.php` | GET | `/sign-up.php` | None | Renders sign-up form | `/sign-up.php` | `AuthController@showRegister` | `auth/register.blade.php` | `AuthParityTest` | **PASS** |
| EP-16 | `sign-up.php` | GET | `/register` | None | Standard route for registration form | `/register` | `AuthController@showRegister` | `auth/register.blade.php` | `AuthParityTest` | **PASS** |
| EP-17 | `sign-up.php` | POST | `/sign-up.php` | `name`, `username`, `email`, `phone`, `password`, `password_confirmation` | Registers new user account | `/sign-up.php` | `AuthController@register` | Redirect to Home | `AuthParityTest` | **PASS** |
| EP-18 | `sign-up.php` | POST | `/register` | `name`, `username`, `email`, `phone`, `password`, `password_confirmation` | Standard POST registration endpoint | `/register` | `AuthController@register` | Redirect to Home | `AuthParityTest` | **PASS** |
| EP-19 | `components/user-sign-out.php` | POST | `/logout` | `_token` | Flushes session and logs user out | `/logout` | `AuthController@logout` | Redirect to Home | `AuthParityTest` | **PASS** |
| EP-20 | `components/user-sign-out.php` | GET | `/logout` | None | GET alias for logout | `/logout` | `AuthController@logout` | Redirect to Home | `AuthParityTest` | **PASS** |
| EP-21 | `forgot-password.php` | GET | `/forgot-password.php` | None | Renders forgot password form | `/forgot-password.php` | `AuthController@showForgotPassword` | `auth/forgot-password.blade.php` | `LegacyEndpointParityTest` | **PASS** |
| EP-22 | `forgot-password.php` | POST | `/forgot-password.php` | `fullname`, `email`, `phone` | Validates user identity for reset | `/forgot-password.php` | `AuthController@handleForgotPassword` | Redirect to `/reset-password.php` | `LegacyEndpointParityTest` | **PASS** |
| EP-23 | `reset-password.php` | GET | `/reset-password.php` | None | Renders reset password form | `/reset-password.php` | `AuthController@showResetPassword` | `auth/reset-password.blade.php` | `LegacyEndpointParityTest` | **PASS** |
| EP-24 | `reset-password.php` | POST | `/reset-password.php` | `new_pass`, `cpass` | Updates user password in database | `/reset-password.php` | `AuthController@handleResetPassword` | Redirect to `/login` | `LegacyEndpointParityTest` | **PASS** |
| EP-25 | `cart.php` | GET | `/cart.php` | None | Renders user shopping cart | `/cart.php` | `CartController@index` | `cart/index.blade.php` | `CartParityTest` | **PASS** |
| EP-26 | `cart.php` | GET | `/cart` | None | Standard route for shopping cart | `/cart` | `CartController@index` | `cart/index.blade.php` | `CartParityTest` | **PASS** |
| EP-27 | `cart.php` | GET | `/cart.php?delete_all=1` | `delete_all=1` | Clears user cart via query parameter | `/cart.php` | `CartController@index` | Redirect to `/cart.php` | `CartParityTest` | **PASS** |
| EP-28 | `cart.php` | POST | `/cart.php` | `cart_id`, `qty`, `update_qty`/`delete` | Processes inline update/delete from cart form | `/cart.php` | `CartController@index` | Redirect + Flash message | `CartParityTest` | **PASS** |
| EP-29 | `cart.php` | POST | `/cart/add` | `product_id`/`pid`, `quantity`/`qty` | Adds product item to cart | `/cart/add` | `CartController@add` | Redirect + Flash message | `CartParityTest` | **PASS** |
| EP-30 | `cart.php` | PUT | `/cart/{id}` | `quantity` | Updates cart item quantity | `/cart/{id}` | `CartController@update` | Redirect + Flash message | `CartParityTest` | **PASS** |
| EP-31 | `cart.php` | DELETE | `/cart/{id}` | None | Removes single item from cart | `/cart/{id}` | `CartController@remove` | Redirect + Flash message | `CartParityTest` | **PASS** |
| EP-32 | `cart.php` | DELETE | `/cart/clear` | None | Clears all user cart items | `/cart/clear` | `CartController@clear` | Redirect + Flash message | `CartParityTest` | **PASS** |
| EP-33 | `checkout.php` | GET | `/checkout.php` | None | Renders checkout billing & payment form | `/checkout.php` | `OrderController@checkout` | `orders/checkout.blade.php` | `CheckoutParityTest` | **PASS** |
| EP-34 | `checkout.php` | GET | `/checkout` | None | Standard route for checkout | `/checkout` | `OrderController@checkout` | `orders/checkout.blade.php` | `CheckoutParityTest` | **PASS** |
| EP-35 | `checkout.php` | POST | `/checkout.php` | `firstname`, `lastname`, `email`, `number`, `address`, `address2`, `country`, `city`, `zip`, `method`, `cc-name`, `cc-number`, `total_products`, `total_price` | Creates order, increments `sold`, clears cart | `/checkout.php` | `OrderController@store` | Redirect to `/orders` | `CheckoutParityTest` | **PASS** |
| EP-36 | `checkout.php` | POST | `/checkout` | `name`, `number`, `email`, `method`, `address`, `address2`, `total_products`, `total_price` | Standard POST checkout endpoint | `/checkout` | `OrderController@store` | Redirect to `/orders` | `CheckoutParityTest` | **PASS** |
| EP-37 | `purchase-history.php` | GET | `/purchase-history.php` | None | Renders customer order history | `/purchase-history.php` | `OrderController@index` | `orders/index.blade.php` | `OrderParityTest` | **PASS** |
| EP-38 | `purchase-history.php` | GET | `/orders` | None | Standard route for order history | `/orders` | `OrderController@index` | `orders/index.blade.php` | `OrderParityTest` | **PASS** |
| EP-39 | `purchase-history-details.php` | GET | `/purchase-history-details.php` | `pid` (order ID) | Displays order detail view for given order ID | `/purchase-history-details.php` | `OrderController@index` / `show` | `orders/show.blade.php` | `OrderParityTest` | **PASS** |
| EP-40 | `purchase-history-details.php` | GET | `/orders/{id}` | `id` | Standard RESTful route for order details | `/orders/{id}` | `OrderController@show` | `orders/show.blade.php` | `OrderParityTest` | **PASS** |
| EP-41 | `users-profile.php` | GET | `/users-profile.php` | None | Renders user profile settings | `/users-profile.php` | `ProfileController@show` | `profile/show.blade.php` | `ProfileParityTest` | **PASS** |
| EP-42 | `users-profile.php` | POST | `/users-profile.php` | `fullname`, `username`, `phone`, `email`, `country`, `address`, `about` | Updates user profile settings | `/users-profile.php` | `ProfileController@update` | Redirect + Flash message | `ProfileParityTest` | **PASS** |
| EP-43 | `Admin/index.php` | GET | `/Admin` & `/Admin/index.php` | None | Renders Admin Dashboard overview | `/Admin` | `Admin\DashboardController@index` | `admin/dashboard.blade.php` | `AdminParityTest` | **PASS** |
| EP-44 | `Admin/admin-sign-in.php` | GET & POST | `/Admin/admin-sign-in.php` | `username`, `pass` | Admin sign in form and authentication | `/Admin/admin-sign-in.php` | `AuthController@login` | Redirect to Admin Dashboard | `AdminParityTest` | **PASS** |
| EP-45 | `Admin/admin-sign-out.php` | GET & POST | `/Admin/admin-sign-out.php` | None | Admin logout handler | `/Admin/admin-sign-out.php` | `AuthController@logout` | Redirect to Home | `AdminParityTest` | **PASS** |
| EP-46 | `Admin/penjualan-list-produk.php` | GET | `/Admin/penjualan-list-produk.php` | None | Renders admin product catalog table | `/Admin/penjualan-list-produk.php` | `Admin\ProductController@index` | `admin/products/index.blade.php` | `AdminParityTest` | **PASS** |
| EP-47 | `Admin/penjualan-add-produk.php` | GET & POST | `/Admin/penjualan-add-produk.php` | `name`, `details`, `categories`, `ingredient`, `price`, `image` | Renders form and creates product | `/Admin/penjualan-add-produk.php` | `Admin\ProductController@create`/`store` | `admin/products/create.blade.php` | `AdminParityTest` | **PASS** |
| EP-48 | `Admin/penjualan-history-pesanan.php` | GET | `/Admin/penjualan-history-pesanan.php` | None | Renders admin order management table | `/Admin/penjualan-history-pesanan.php` | `Admin\OrderController@index` | `admin/orders/index.blade.php` | `AdminParityTest` | **PASS** |
| EP-49 | `Admin/users.php` | GET | `/Admin/users.php` | None | Renders admin user management tables | `/Admin/users.php` | `Admin\UserController@index` | `admin/users/index.blade.php` | `AdminParityTest` | **PASS** |
| EP-50 | `Admin/messages` | GET & DELETE | `/Admin/messages` & `/Admin/messages/{id}` | `id` | Displays and deletes contact messages | `/Admin/messages` | `Admin\MessageController@index`/`destroy` | `admin/messages/index.blade.php` | `AdminParityTest` | **PASS** |
