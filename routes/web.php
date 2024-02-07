<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use Illuminate\Contracts\View\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/signup', [UserController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [UserController::class, 'signup']);
Route::get('/login', function () {
    return view('frontend.auth.login');
})->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth.user')->group(function () {
    Route::get('/product-listing', function () {
        return view('frontend.pages.listing');
    })->name('listing');
});

Route::get('/admin/login', [AdminController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.loginAction');
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendPasswordResetEmail'])->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('admin.password.resetPass');

Route::middleware('auth.admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/update-profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('admin.changePassword');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}', [UserController::class, 'toggleUser'])->name('users.toggle');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
