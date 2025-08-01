<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIslogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// auth routes - user not logged
Route::middleware([CheckIsNotlogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// app routes - user logged
Route::middleware([CheckIslogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

