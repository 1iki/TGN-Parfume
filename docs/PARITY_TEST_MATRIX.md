# PARITY TEST MATRIX — TGN PARFUME

| Domain | Test Name | Test File | Target Scenario | Result | Assertions |
|--------|-----------|-----------|-----------------|--------|------------|
| **Unit** | `test_that_true_is_true` | `tests/Unit/ExampleTest.php` | Framework sanity check | **PASS** | 1 |
| **Auth** | `test_login_page_renders_successfully` | `tests/Feature/AuthTest.php` | Renders `/login` & `/sign-in.php` | **PASS** | 2 |
| **Auth** | `test_invalid_login_credentials_rejected` | `tests/Feature/AuthTest.php` | Rejects wrong password with error session | **PASS** | 2 |
| **Auth** | `test_sha1_password_auto_upgrades_to_bcrypt_on_login` | `tests/Feature/AuthTest.php` | Verifies SHA-1 hash and upgrades to Bcrypt | **PASS** | 5 |
| **Auth** | `test_disabled_account_cannot_login` | `tests/Feature/AuthTest.php` | Prevents disabled accounts from logging in | **PASS** | 2 |
| **Auth** | `test_logout_invalidates_session` | `tests/Feature/AuthTest.php` | Flushes session and logs out | **PASS** | 2 |
| **Admin** | `test_unauthenticated_user_redirected_from_admin_dashboard` | `tests/Feature/AdminAccessTest.php` | Redirects guests to `/login` | **PASS** | 1 |
| **Admin** | `test_customer_user_denied_admin_access` | `tests/Feature/AdminAccessTest.php` | Redirects customer level users to `/` | **PASS** | 1 |
| **Admin** | `test_admin_user_granted_access` | `tests/Feature/AdminAccessTest.php` | Renders `/Admin` for Super Admin | **PASS** | 2 |
| **Cart** | `test_user_can_add_product_to_cart` | `tests/Feature/CartTest.php` | Adds product item to `cart` collection | **PASS** | 3 |
| **Cart** | `test_adding_duplicate_product_increments_quantity` | `tests/Feature/CartTest.php` | Increments `quantity` on duplicate add | **PASS** | 1 |
| **Cart** | `test_user_can_clear_cart` | `tests/Feature/CartTest.php` | Empties user items in `cart` collection | **PASS** | 1 |
| **Cart** | `test_legacy_delete_all_query_param_clears_cart` | `tests/Feature/CartTest.php` | Handles `GET /cart.php?delete_all=1` | **PASS** | 1 |
| **Checkout** | `test_checkout_creates_order_increments_sold_and_clears_cart` | `tests/Feature/CheckoutTest.php` | Creates order, increments `sold`, clears cart | **PASS** | 5 |
| **Route** | `test_home_page_and_legacy_index_url_accessible` | `tests/Feature/RouteTest.php` | `/` and `/index.php` render 200 OK | **PASS** | 2 |
| **Route** | `test_about_page_accessible` | `tests/Feature/RouteTest.php` | `/about` renders 200 OK | **PASS** | 1 |
| **Route** | `test_contact_page_accessible` | `tests/Feature/RouteTest.php` | `/contact` renders 200 OK | **PASS** | 1 |
| **Route** | `test_products_catalog_page_and_legacy_url_accessible` | `tests/Feature/RouteTest.php` | `/products` and `/product.php` render 200 OK | **PASS** | 2 |
| **Route** | `test_product_detail_page_loads_correct_product` | `tests/Feature/RouteTest.php` | `/products/{id}` displays product details | **PASS** | 3 |
| **Route** | `test_search_endpoint_returns_matching_products` | `tests/Feature/RouteTest.php` | `/search?search=Blue` finds product | **PASS** | 2 |
| **Sanity** | `test_the_application_returns_a_successful_response` | `tests/Feature/ExampleTest.php` | App boot check | **PASS** | 1 |
| **Product** | `test_product_catalog_displays_products` | `tests/Feature/ProductTest.php` | Renders product catalog | **PASS** | 2 |
| **Product** | `test_admin_can_create_product` | `tests/Feature/ProductTest.php` | Creates product document | **PASS** | 3 |
| **Product** | `test_admin_can_update_product` | `tests/Feature/ProductTest.php` | Updates product details/price | **PASS** | 3 |
| **Product** | `test_admin_can_delete_product` | `tests/Feature/ProductTest.php` | Removes product document | **PASS** | 2 |
| **Order** | `test_customer_can_view_own_orders` | `tests/Feature/OrderTest.php` | Renders order history | **PASS** | 2 |
| **Order** | `test_admin_can_view_all_orders` | `tests/Feature/OrderTest.php` | Renders admin order history | **PASS** | 1 |
| **Order** | `test_admin_can_update_order_payment_status` | `tests/Feature/OrderTest.php` | Updates order `payment_status` | **PASS** | 2 |
| **Order** | `test_admin_can_delete_order` | `tests/Feature/OrderTest.php` | Deletes order document | **PASS** | 2 |
| **User** | `test_admin_can_view_user_lists` | `tests/Feature/UserManagementTest.php` | Renders user & employee tables | **PASS** | 4 |
| **User** | `test_admin_can_toggle_user_status` | `tests/Feature/UserManagementTest.php` | Toggles status Active <-> Disabled | **PASS** | 3 |
| **User** | `test_admin_can_delete_user` | `tests/Feature/UserManagementTest.php` | Removes user account | **PASS** | 2 |
| **Message** | `test_user_can_submit_contact_message` | `tests/Feature/MessageTest.php` | Persists message from storefront | **PASS** | 3 |
| **Message** | `test_admin_can_view_and_delete_messages` | `tests/Feature/MessageTest.php` | Admin views & deletes message | **PASS** | 3 |
| **Security** | `test_customer_cannot_access_admin_dashboard` | `tests/Feature/SecurityTest.php` | Restricts customer from `/Admin` | **PASS** | 1 |
| **Security** | `test_customer_cannot_delete_another_users_cart_item` | `tests/Feature/SecurityTest.php` | IDOR prevention on cart items | **PASS** | 1 |
| **Security** | `test_malformed_objectid_handled_gracefully` | `tests/Feature/SecurityTest.php` | Returns 404 on malformed ObjectId | **PASS** | 1 |
| **Security** | `test_customer_cannot_access_another_users_order` | `tests/Feature/SecurityTest.php` | IDOR prevention on order details | **PASS** | 1 |
| **Asset** | `test_storefront_assets_exist` | `tests/Feature/AssetTest.php` | Verifies `assets/css/main.css` | **PASS** | 1 |
| **Asset** | `test_admin_assets_exist` | `tests/Feature/AssetTest.php` | Verifies `Admin/assets/css/style.css` | **PASS** | 3 |
| **Asset** | `test_images_directory_exists` | `tests/Feature/AssetTest.php` | Verifies `images/` & `uploaded_img/` | **PASS** | 2 |
| **Profile** | `test_authenticated_user_accessing_profile_redirects_or_renders` | `tests/Feature/ProfileTest.php` | Verifies profile route accessibility | **PASS** | 1 |
| **Legacy** | `test_legacy_forgot_password_flow` | `tests/Feature/LegacyParityMatrixTest.php` | Verifies legacy `forgot-password.php` & `reset-password.php` | **PASS** | 5 |
| **Legacy** | `test_legacy_users_profile_view_and_update` | `tests/Feature/LegacyParityMatrixTest.php` | Verifies legacy `users-profile.php` view & update | **PASS** | 4 |
| **Legacy** | `test_legacy_product_detail_page_and_add_to_cart` | `tests/Feature/LegacyParityMatrixTest.php` | Verifies legacy `product.php` & add to cart POST | **PASS** | 4 |
| **Legacy** | `test_legacy_checkout_form_submission` | `tests/Feature/LegacyParityMatrixTest.php` | Verifies legacy `checkout.php` form POST | **PASS** | 3 |

**Total Tests**: 46 PASSED | **Total Assertions**: 129 PASSED | **Status**: **PASS**
