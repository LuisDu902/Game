<?php

use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Models\User;
use Illuminate\Http\Request;

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

// Home
Route::redirect('/', '/home');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/users/{id}', 'showUserProfile')->name('profile');
    Route::get('/users', 'index')->name('users');
    Route::get('/users/questions/{id}', 'showUserQuestions')->name('users_questions');
    Route::get('/users/answers/{id}', 'showUserAnswers')->name('users_answers');
});

// Question
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions');
    Route::get('/questions/new-question', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/new-question', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/new-question', [GameController::class, 'index'])->name('questions.create');
   
});

// Game Category
Route::controller(GameCategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categories/{id}', 'show')->name('category');
});

// Game
Route::controller(GameController::class)->group(function () {
    Route::get('/game/{id}', 'show')->name('game');
});

// User API
Route::controller(UserController::class)->group(function () {
    Route::get('/api/users', 'search');
    Route::post('/api/users/{id}', 'updateStatus');
    Route::post('/api/users/{id}/edit', 'edit');
});

// Question API
Route::controller(QuestionController::class)->group(function () {
    Route::get('/api/questions', 'list'); 
});