<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



// User routes
Route::post('/user-registration', [UserController::class, 'register'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'login'])->name('user.login');
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('user.sendOtp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('user.verifyOtp');

Route::post('/reset-password', [UserController::class, 'resetPassword']);

Route::get('/reset-password-page', [UserController::class, 'resetPasswordPage'])->name('resetPasswordPage');

// Auth Page routes
Route::get('/login', [UserController::class, 'loginPage'])->name('loginPage');
Route::get('/register', [UserController::class, 'registerPage'])->name('registerPage');
Route::get('/forgot-password', [UserController::class, 'forgotPasswordPage'])->name('forgotPassword');
Route::get('/verify-otp', [UserController::class, 'verifyOtpPage'])->name('verifyOtp');

Route::middleware(TokenVerificationMiddleware::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::get('/logout', [UserController::class, 'logout']);


    // Category Routes
    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('category.create');
    Route::get('/categories', [CategoryController::class, 'categories'])->name('category.index');
    Route::get('/category-save-page', [CategoryController::class, 'categorySavePage'])->name('category.savePage');
    Route::get('/categories/{id}', [CategoryController::class, 'category'])->name('category.single');
    Route::post('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');


    // Product Routes
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('product.create');
    Route::get('/products', [ProductController::class, 'products'])->name('product.index');
    Route::get('/product-save-page', [ProductController::class, 'productSavePage'])->name('product.savePage');
    Route::get('/products/{id}', [ProductController::class, 'product'])->name('product.single');
    Route::post('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::delete('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');


    // customer routes 
    Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->name('customer.create');
    Route::get('/customers', [CustomerController::class, 'customers'])->name('customer.index');
    Route::get('/customer-save-page', [CustomerController::class, 'customerSavePage'])->name('customer.savePage');
    Route::get('/customers/{id}', [CustomerController::class, 'customer'])->name('customer.single');
    Route::post('/update-customer/{id}', [CustomerController::class, 'updateCustomer'])->name('customer.update');
    Route::delete('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('customer.delete');


    // Invoice Routes
    Route::post('/create-invoice', [InvoiceController::class, 'createInvoice'])->name('invoice.create');
    Route::get('/invoices', [InvoiceController::class, 'invoices'])->name('invoices');
    Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->name('invoice.details');
    Route::delete('/delete-invoice/{id}', [InvoiceController::class, 'deleteInvoice'])->name('invoice.delete');
    Route::get('/create-sale', [SaleController::class, 'sale'])->name('sale');
});
