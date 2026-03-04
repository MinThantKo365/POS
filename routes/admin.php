<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('home', [AdminController::class, 'AdminHome'])->name('AdminHome');

    // Category List
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', [CategoryController::class, 'categoryList'])->name('category#List');
        Route::post('create', [CategoryController::class, 'create'])->name('#create');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('#delete');
        Route::get('update/{id}', [CategoryController::class, 'updatePage'])->name('update#Page');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update#List');
    });

    // Products (real-world admin CRUD)
    Route::resource('products', ProductController::class)->names([
        'index'   => 'admin.products.index',
        'create'  => 'admin.products.create',
        'store'   => 'admin.products.store',
        'edit'    => 'admin.products.edit',
        'update'  => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ])->parameters([
        'products' => 'product',
    ]);

    // password List
    Route::group(['prefix' => 'password'], function () {
        Route::get('change_password', [ProfileController::class, 'changePasswordPage'])->name('change#pwd');
        Route::post('change_password', [ProfileController::class, 'changePasswordPost'])->name('change#pwd#update');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('account-profile', [ProfileController::class, 'ProfilePage'])->name('profile#page');
        Route::post('change_password', [ProfileController::class, 'changePasswordPost'])->name('change#pwd#update');
    });

    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });
}
);

?>

