<?php

use App\Http\Controllers\Manage\AccountController;
use App\Http\Controllers\Manage\AssetController;
use App\Http\Controllers\Manage\ClientController;
use App\Http\Controllers\Manage\CompanyController;
use App\Http\Controllers\Manage\ProductController;
use App\Http\Controllers\Manage\TestimonialController;
use App\Http\Controllers\Manage\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('manage')->middleware(['auth', 'access'])->group(function () {
    Route::name('user.')->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user:id}', [UserController::class, 'show'])->name('show');
        Route::get('/{user:id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{user:id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{user:id}/destroy', [UserController::class, 'destroy'])->name('destroy');

        Route::patch('/{user:id}/status/update/{status?}', [UserController::class, 'updateStatus'])->name('status.update');
        Route::get('/history', [UserController::class, 'history'])->name('history');
    });

    Route::name('account.')->prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/store', [AccountController::class, 'store'])->name('store');
        Route::get('/{account:id}', [AccountController::class, 'show'])->name('show');
        Route::get('/{account:id}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::patch('/{account:id}/update', [AccountController::class, 'update'])->name('update');
        Route::delete('/{account:id}/destroy', [AccountController::class, 'destroy'])->name('destroy');
    });

    Route::name('company.')->prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::get('/{company:id}', [CompanyController::class, 'show'])->name('show');
        Route::get('/{company:id}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::post('/{company:id}/update', [CompanyController::class, 'update'])->name('update');
        Route::delete('/{company:id}/destroy', [CompanyController::class, 'destroy'])->name('destroy');
    });

    Route::name('product.')->prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{product:id}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product:id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{product:id}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product:id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::name('testimonial.')->prefix('testimonials')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('index');
        Route::patch('/update', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{testimonial:id}/destroy', [TestimonialController::class, 'destroy'])->name('destroy');
    });

    Route::name('asset.')->prefix('assets')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/create', [AssetController::class, 'create'])->name('create');
        Route::post('/store', [AssetController::class, 'store'])->name('store');
        Route::get('/{asset:id}', [AssetController::class, 'show'])->name('show');
        Route::get('/{asset:id}/edit', [AssetController::class, 'edit'])->name('edit');
        Route::patch('/{asset:id}/update', [AssetController::class, 'update'])->name('update');
        Route::delete('/{asset:id}/destroy', [AssetController::class, 'destroy'])->name('destroy');
    });

    Route::name('client.')->prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::get('/{client:id}', [ClientController::class, 'show'])->name('show');
        Route::get('/{client:id}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::patch('/{client:id}/update', [ClientController::class, 'update'])->name('update');
        Route::delete('/{client:id}/destroy', [ClientController::class, 'destroy'])->name('destroy');
    });
});
