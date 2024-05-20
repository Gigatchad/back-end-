<?php
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controller\UserController;
Route::get('/cities', [CityController::class, 'index']);



Route::get('/products', [ProductController::class, 'index']);


Route::get('/categories', [CategoryController::class, 'index']);
// routes/web.php



// Route pour afficher les détails d'un produit et les produits similaires
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// routes/api.php






Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/cart', [CartController::class, 'addToCart']);
Route::get('/cart/{userId}', [CartController::class, 'viewCart']);
Route::put('/cart/{id}', [CartController::class, 'updateCart']);
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart']);

Route::post('/orders', [OrderController::class, 'placeOrder']);
// Authentification
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');

// Inscription
Route::post('register', 'AuthController@register');
Route::middleware('auth.api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->post('/checkout', 'OrderController@checkout');
// Dans routes/web.php ou routes/admin.php

Route::middleware(['auth', 'admin'])->group(function () {
    // Routes d'administration...
});
Route::post('/users/{userId}/block', 'UserController@blockUser');
Route::post('/users/{userId}/add-admin', 'UserController@addAdmin');
Route::post('/users/{userId}/remove-admin', 'UserController@removeAdmin');
