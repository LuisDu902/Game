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
    Route::post('/edit_profile/{id}', 'edit')->name('edit_profile');
    Route::get('/users', 'index')->name('users');
    Route::get('/users/questions/{id}', 'showUserQuestions')->name('users_questions');
});

// Question
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions');
   
});


// Question
Route::controller(GameCategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categories/{id}', 'show')->name('category');
});

Route::controller(GameController::class)->group(function () {
    Route::get('/game/{id}', 'show')->name('game');
});


Route::controller(UserController::class)->group(function () {
    Route::post('/api/users/{id}', 'updateStatus');
    Route::get('/api/users/', 'list');
});
