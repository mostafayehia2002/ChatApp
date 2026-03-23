<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest routes (unauthenticated users)
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
    // Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});
// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Home/Dashboard
    Route::match(['GET','POST'],'/home', [HomeController::class, 'index'])->name('home');
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
     //chat
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    //conversation
    Route::get('/conversation/{id}', [ConversationController::class, 'showConversation'])->name('conversation.show');
});
