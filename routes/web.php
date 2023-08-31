<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    });
});


require __DIR__ . '/auth.php';
