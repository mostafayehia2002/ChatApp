<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('users.login');
});
Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'guest'], function () {
    Route::get('/login', [LoginUserController::class, 'index'])->name('login');
    Route::post('/login', [LoginUserController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterUserController::class, 'index'])->name('register');
    Route::post('/store', [RegisterUserController::class, 'store'])->name('store');
});
Route::group(['middleware' => 'auth'], function () {
    //home page route
    Route::view('/home', 'index')->name('home');
    //logout
   // Route::post('/logout', [LogoutUserController::class, 'logout'])->name('users.logout');
});
