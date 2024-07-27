<?php

use App\Http\Controllers\System\AssetTypeController;
use App\Http\Controllers\System\PaymentSectorController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('system')->middleware(['auth', 'access'])->group(function () {
    Route::name('role.')->prefix('user-roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');

        Route::name('permission.')->prefix('{role:id}/permission')->group(function () {
            Route::get('/', [RoleController::class, 'permission'])->name('edit');
            Route::patch('/', [RoleController::class, 'permissionUpdate'])->name('update');
        });
    });

    Route::name('sector.')->prefix('payment-sectors')->group(function () {
        Route::get('/', [PaymentSectorController::class, 'index'])->name('index');
        Route::get('/create', [PaymentSectorController::class, 'create'])->name('create');
        Route::post('/store', [PaymentSectorController::class, 'store'])->name('store');
        Route::get('/{sector:id}/edit', [PaymentSectorController::class, 'edit'])->name('edit');
        Route::patch('/{sector:id}/update', [PaymentSectorController::class, 'update'])->name('update');
        Route::delete('/{sector:id}/destroy', [PaymentSectorController::class, 'destroy'])->name('destroy');
        Route::get('/{sector:id}', [PaymentSectorController::class, 'show'])->name('show');
    });

    Route::name('type.')->prefix('asset-types')->group(function () {
        Route::get('/', [AssetTypeController::class, 'index'])->name('index');
        Route::get('/create', [AssetTypeController::class, 'create'])->name('create');
        Route::post('/store', [AssetTypeController::class, 'store'])->name('store');
        Route::get('/{type:id}/edit', [AssetTypeController::class, 'edit'])->name('edit');
        Route::patch('/{type:id}/update', [AssetTypeController::class, 'update'])->name('update');
        Route::delete('/{type:id}/destroy', [AssetTypeController::class, 'destroy'])->name('destroy');
        Route::get('/{type:id}', [AssetTypeController::class, 'show'])->name('show');
    });

    Route::name('setting.')->prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'edit'])->name('edit');
        Route::patch('/', [SettingController::class, 'update'])->name('update');
    });
});
