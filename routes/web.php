<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Middleware\AdminMiddleware;

// Public Storefront Routes & Legacy PHP URL Aliases
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index.php', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product.php', function (\Illuminate\Http\Request $request) {
    if ($request->has('pid')) {
        return app(ProductController::class)->show($request->input('pid'));
    }
    return app(ProductController::class)->index($request);
});
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Password Reset Routes (Legacy PHP & Standard Laravel Aliases)
Route::get('/forgot-password.php', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
Route::post('/forgot-password.php', [AuthController::class, 'handleForgotPassword'])->name('password.forgot.post');
Route::get('/reset-password.php', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password.php', [AuthController::class, 'handleResetPassword'])->name('password.reset.post');

// Auth Routes (Guest & Legacy PHP URL Aliases)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/sign-in.php', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/sign-in.php', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/sign-up.php', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/sign-up.php', [AuthController::class, 'register']);
});

// Authenticated Customer Routes & Legacy PHP URL Aliases
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/product.php', [CartController::class, 'add']);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart.php', [CartController::class, 'index']);
    Route::post('/cart.php', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/checkout.php', [OrderController::class, 'checkout']);
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::post('/checkout.php', [OrderController::class, 'store']);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/purchase-history.php', [OrderController::class, 'index']);
    Route::get('/purchase-history-details.php', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/users-profile.php', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/users-profile.php', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update']);
});

// Protected Admin Panel Routes & Legacy PHP Admin URL Aliases
Route::prefix('Admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/index.php', [AdminDashboardController::class, 'index']);

    Route::get('/penjualan-list-produk.php', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products', [AdminProductController::class, 'index']);

    Route::get('/penjualan-add-produk.php', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/penjualan-add-produk.php', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::post('/products', [AdminProductController::class, 'store']);

    Route::get('/penjualan-edit-produk.php', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/penjualan-history-pesanan.php', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    Route::get('/users.php', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users-tabel-konsumen.php', [AdminUserController::class, 'index']);
    Route::get('/users-tabel-karyawan.php', [AdminUserController::class, 'index']);
    Route::get('/users-tabel-admin.php', [AdminUserController::class, 'index']);
    Route::patch('/users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/messages', [AdminMessageController::class, 'index'])->name('admin.messages.index');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('admin.messages.destroy');

    Route::get('/users-profile.php', [AdminUserController::class, 'profile'])->name('admin.profile');
    Route::post('/users-profile.php', [AdminUserController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/profile', [AdminUserController::class, 'profile']);
    Route::post('/profile', [AdminUserController::class, 'updateProfile']);
});

// Admin Sign-in & Sign-out legacy URL aliases outside or inside Admin
Route::get('/components/user-sign-out.php', [AuthController::class, 'logout']);
Route::post('/components/user-sign-out.php', [AuthController::class, 'logout']);
Route::get('/Admin/admin-sign-in.php', [AuthController::class, 'showLogin']);
Route::post('/Admin/admin-sign-in.php', [AuthController::class, 'login']);
Route::get('/Admin/admin-sign-out.php', [AuthController::class, 'logout']);
Route::post('/Admin/admin-sign-out.php', [AuthController::class, 'logout']);
