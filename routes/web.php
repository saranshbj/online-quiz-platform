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
        Route::match(['get', 'post'], 'quizzes', [AdminController::class, 'addQuiz'])->name('quizzes');
        Route::get('getQuiz', [AdminController::class, 'getQuiz'])->name('getQuizzes');
        Route::delete('deleteQuiz/{quizId}', [AdminController::class, 'deleteQuiz'])->name('deleteQuiz');
        Route::get('addQuestion/{quizId}', [AdminController::class, 'addQuestion'])->name('addQuestion');
        Route::post('saveQuestion', [AdminController::class, 'saveQuestion'])->name('saveQuestion');
        Route::get('getQuestion/{quizId}', [AdminController::class, 'getQuestion'])->name('getQuestion');
        Route::delete('deleteQuestion/{questionId}', [AdminController::class, 'deleteQuestion'])->name('deleteQuestion');
        Route::get('userResult',[AdminController::class, 'userResult'])->name('userResult');
        Route::get('userAnswer/{quizId}/{userId}', [AdminController::class, 'userAnswer'])->name('userAnswer');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('availableQuiz', [UserController::class, 'availableQuiz'])->name('availableQuiz');
        Route::get('seeQuiz', [UserController::class, 'seeQuiz'])->name('seeQuiz');
        Route::match(['get', 'post'], 'takeQuiz/{quizId}', [UserController::class, 'takeQuiz'])->name('takeQuiz');
        Route::get('quizResult', [UserController::class, 'quizResult'])->name('quizResult');
        Route::get('viewAnswer/{quizId}', [UserController::class, 'viewAnswer'])->name('viewAnswer');
    });
});


require __DIR__ . '/auth.php';
