<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ReportController;
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
    Route::get('/recover', 'recover')->name('recover');
    Route::post('/newPassword', 'resetPassword')->name('resetPassword');
    Route::get('/newPassword', 'newPassword')->name('newPassword');
    Route::get('/emailSent', 'emailSent')->name('emailSent');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(MailController::class)->group(function(){
    Route::post('/recoverPassword', 'send')->name('recoverPassword');
    Route::post('/contact', 'contact')->name('contact');
});

// Static pages
Route::controller(StaticController::class)->group(function () {
    Route::get('/home', 'home')->name('home');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
});

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

Route::controller(ReportController::class)->group(function () {
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::post('/report2', [ReportController::class, 'store2'])->name('report.store2');
    Route::post('/report3', [ReportController::class, 'store3'])->name('report.store3');
});


// File Storage
Route::controller(FileController::class)->group(function () {
    Route::post('/api/file/upload', 'upload');
    Route::delete('/api/file/delete', 'clear');
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





