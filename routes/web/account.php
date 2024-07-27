<?php

use App\Http\Controllers\Account\BillController;
use App\Http\Controllers\Account\CollectionController;
use App\Http\Controllers\Account\PaymentController;
use App\Http\Controllers\Account\PettyCashController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->middleware(['auth', 'access'])->group(function () {
    Route::name('payment.')->prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
        Route::get('/{payment:id}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{payment:id}/edit', [PaymentController::class, 'edit'])->name('edit');
        Route::patch('/{payment:id}/update', [PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment:id}/destroy', [PaymentController::class, 'destroy'])->name('destroy');
    });

    Route::name('bill.')->prefix('bills')->group(function () {
        Route::get('/', [BillController::class, 'index'])->name('index');
        Route::get('/create', [BillController::class, 'create'])->name('create');
        Route::post('/store', [BillController::class, 'store'])->name('store');
        Route::get('/{bill:id}', [BillController::class, 'show'])->name('show');
        Route::get('/{bill:id}/edit', [BillController::class, 'edit'])->name('edit');
        Route::patch('/{bill:id}/update', [BillController::class, 'update'])->name('update');
        Route::delete('/{bill:id}/destroy', [BillController::class, 'destroy'])->name('destroy');
    });

    Route::name('collection.')->prefix('collections')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('/create', [CollectionController::class, 'create'])->name('create');
        Route::post('/store', [CollectionController::class, 'store'])->name('store');
        Route::get('/{collection:id}', [CollectionController::class, 'show'])->name('show');
        Route::get('/{collection:id}/edit', [CollectionController::class, 'edit'])->name('edit');
        Route::patch('/{collection:id}/update', [CollectionController::class, 'update'])->name('update');
        Route::delete('/{collection:id}/destroy', [CollectionController::class, 'destroy'])->name('destroy');
    });

    Route::name('petty_cash.')->prefix('petty-cashes')->group(function () {
        Route::get('/', [PettyCashController::class, 'index'])->name('index');
        Route::get('/create', [PettyCashController::class, 'create'])->name('create');
        Route::post('/store', [PettyCashController::class, 'store'])->name('store');
        Route::get('/{payment:id}', [PettyCashController::class, 'show'])->name('show');
        Route::get('/{payment:id}/edit', [PettyCashController::class, 'edit'])->name('edit');
        Route::patch('/{payment:id}/update', [PettyCashController::class, 'update'])->name('update');
        Route::delete('/{payment:id}/destroy', [PettyCashController::class, 'destroy'])->name('destroy');
    });
});
