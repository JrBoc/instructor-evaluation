<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student;

Route::get('/login', [Student\LoginController::class, 'login'])->name('login')->middleware('guest:student');

Route::middleware('auth:student')->group(function () {
    Route::get('/dashboard', function () {
        dd(auth('student')->user());
    })->name('dashboard');
});
