<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('github');

Route::get('/auth/callback', function () {
    $git_user = Socialite::driver('github')->user();
    $user = User::updateOrCreate([
        'email' => $git_user->email,
    ], [
        'name' => $git_user->name,
        'email' => $git_user->email,
        'github_id' => $git_user->id,
        'github_token' => $git_user->token,
        'github_refresh_token' => $git_user->refreshToken,
        'password' => bcrypt($git_user->email),
        'is_admin' => 1,
        'created_at' => now(),
        'email_verified_at' => now(),
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/language', [HomeController::class, 'language'])->name('language');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('profile.')->prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'profile'])->name('index');
        Route::post('update', [ProfileController::class, 'update'])->name('update');

        Route::get('password', [ProfileController::class, 'password'])->name('password');
        Route::patch('password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::name('statement.')->prefix('statement')->group(function () {
        Route::get('receivable', [AccountController::class, 'receivable'])->name('receivable');
        Route::get('payable', [AccountController::class, 'payable'])->name('payable');
    });
});

require __DIR__.'/web/operation.php';

require __DIR__.'/web/account.php';

require __DIR__.'/web/manage.php';

require __DIR__.'/web/system.php';

require __DIR__.'/auth.php';
