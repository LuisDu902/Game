<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Models\User;
use App\Models\Comment;
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

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');


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
    Route::get('/questions/search', 'search')->name('questions.search');
    Route::get('/questions/create', 'create')->name('questions.create');
    Route::get('/questions/{id}', 'show')->name('question');    
    Route::get('/questions/{id}/edit', 'edit')->name('questions.edit');
    Route::get('/questions/{id}/activity', 'activity')->name('questions.activity');
    Route::delete('/questions/{id}', 'delete')->name('questions.destroy');
});

// File Storage
Route::controller(FileController::class)->group(function () {
    Route::post('/api/file/upload', 'upload');
    Route::delete('/api/file/delete', 'clear');
});

Route::controller(GameCategoryController::class)->group(function () {
    Route::post('/api/gamecategories', 'store')->name('categories.store');
});

// Game Category
Route::controller(GameCategoryController::class)->group(function () {
    Route::get('/categories', 'index')->name('categories');
    Route::get('/categories/create', 'create')->name('categories.create');
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
    Route::delete('/api/users/{id}', 'delete')->name('users.destroy');
});

// Question API
Route::controller(QuestionController::class)->group(function () {
    Route::get('/api/questions', 'list');
    Route::post('/api/questions/{id}/vote', 'vote');
    Route::post('/api/questions/{id}/unvote', 'unvote'); 
    Route::post('/api/questions/{id}/visibility', 'visibility'); 
    Route::post('/api/questions', 'store');
    Route::put('/api/questions/{id}', 'update');
});

// Answer API
Route::controller(AnswerController::class)->group(function () {
    Route::post('/api/answers', 'store');
    Route::get('/api/answers/{id}/edit', 'edit');
    Route::put('/api/answers/{id}', 'update');
    Route::delete('/api/answers/{id}', 'delete');
    Route::post('/api/answers/{id}/vote', 'vote');
    Route::post('/api/answers/{id}/unvote', 'unvote'); 
    Route::post('/api/answers/{id}/status', 'status'); 

});

// Comment API
Route::controller(CommentController::class)->group(function () {
    Route::post('/api/comments', 'store');
    Route::get('/api/comments/{id}/edit', 'edit');
    Route::put('/api/comments/{id}', 'update');
    Route::delete('/api/comments/{id}', 'delete');
});

// Tag API
Route::controller(TagController::class)->group(function () {
    Route::post('/api/tags', 'store');
});





