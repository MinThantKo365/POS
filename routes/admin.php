<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'middleware' => 'admin'],function(){
    Route::get('home', [AdminController::class, 'AdminHome'])->name('AdminHome');
});

// Category List
route::group(['prefix' =>'category'],function(){
 Route::get('list', [CategoryController::class, 'categoryList'])->name('category#List');
 Route::post('create', [CategoryController::class, 'create'])->name('#create');
 Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('#delete');
 Route::get('update/{id}', [CategoryController::class, 'updatePage'])->name('update#Page');
 Route::post('update/{id}', [CategoryController::class, 'updatePage'])->name('update#List');
});

// password List
route::group(['prefix' =>'password'],function(){
    Route::get('change_password', [ProfileController::class, 'changePasswordPage'])->name('change#pwd');
     Route::post('change_password', [ProfileController::class, 'changePasswordPost'])->name('change#pwd#update');
   });

route::group(['prefix' =>'profile'],function(){
    Route::get('account-profile', [ProfileController::class, 'ProfilePage'])->name('profile#page');
     Route::post('change_password', [ProfileController::class, 'changePasswordPost'])->name('change#pwd#update');
   });


?>

