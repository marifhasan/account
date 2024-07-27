<?php

use App\Http\Controllers\Operation\JobController;
use Illuminate\Support\Facades\Route;

Route::prefix('operation')->middleware(['auth', 'access'])->group(function () {
    Route::name('job.')->prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('index');
        Route::get('/create', [JobController::class, 'create'])->name('create');
        Route::post('/store', [JobController::class, 'store'])->name('store');
        Route::get('/{job:id}', [JobController::class, 'show'])->name('show');
        Route::get('/{job:id}/edit', [JobController::class, 'edit'])->name('edit');
        Route::patch('/{job:id}/update', [JobController::class, 'update'])->name('update');
        Route::delete('/{job:id}/destroy', [JobController::class, 'destroy'])->name('destroy');
    });
});
