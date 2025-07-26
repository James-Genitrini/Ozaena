<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/panier', [CartController::class, 'show'])->name('cart.show');

    Route::post('/panier/ajouter/{product}', [CartController::class, 'addProduct'])->name('cart.add');
    Route::patch('/panier/modifier/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/panier/supprimer/{product}', [CartController::class, 'removeProduct'])->name('cart.remove');

});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Auth::routes();

Route::get('/produit/{product:slug}', [ProductController::class, 'show'])->name('produit.show');