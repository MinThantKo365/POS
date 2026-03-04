<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'user']], function(){
    // Home
    Route::get('home', [UserController::class, 'userHome'])->name('userHome');
    
    // Products
    Route::get('products', [UserProductController::class, 'index'])->name('user.products.index');
    Route::get('products/{product}', [UserProductController::class, 'show'])->name('user.products.show');
    
    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('user.cart.index');
        Route::post('/', [CartController::class, 'store'])->name('user.cart.store');
        Route::put('/{cart}', [CartController::class, 'update'])->name('user.cart.update');
        Route::delete('/{cart}', [CartController::class, 'destroy'])->name('user.cart.destroy');
        Route::get('/count', [CartController::class, 'count'])->name('user.cart.count');
    });
    
    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('user.orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('user.orders.store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('user.orders.show');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');
    });
});
