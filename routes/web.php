<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

Route::get('/coming-soon', function () {
    $openingDate = Carbon::parse(config('app.opening_date'))
        ->setTimezone(config('app.timezone'));
    $now = Carbon::now()->setTimezone(config('app.timezone'));

    if ($now->gte($openingDate)) {
        return redirect('/');
    }

    return view('coming-soon', [
        'openingDateTimestamp' => $openingDate->timestamp * 1000
    ]);
})->name('coming-soon');


// Page d'accueil
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentification
Auth::routes(['verify' => true]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Panier
Route::get('/panier', [CartController::class, 'show'])->name('cart.show');
Route::post('/panier/ajouter/{product}', [CartController::class, 'addProduct'])->name('cart.add');
Route::patch('/panier/modifier/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/panier/supprimer/{product}', [CartController::class, 'removeProduct'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('auth');

// Produits
Route::get('/produit/{product:slug}', [ProductController::class, 'show'])->name('produit.show');

// Pages statiques
Route::view('/mentions-legales', 'mentions')->name('mentions.legales');
Route::view('/conditions-generales', 'cgv')->name('cgv');

// // Admin (accessible avant ouverture si nécessaire)
// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
//     Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
//     Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
//     Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
// });

// Profil utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{order}/refund', [ProfileController::class, 'refund'])->name('profile.refund');
});