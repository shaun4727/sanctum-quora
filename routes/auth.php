<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::prefix('auth')->group(function(){
    Route::post('/login', [LoginController::class,'login'])->middleware('guest');
    Route::post('/logout', [LogoutController::class,'logout'])->middleware('auth:sanctum');
    Route::post('/register', [RegisterController::class,'register'])->middleware('guest');
    Route::post('/password/email', [PasswordResetController::class,'sendResetLinkEmail'])->middleware('guest');
    Route::post('/password/reset', [PasswordResetController::class,'reset'])->middleware(['guest','signed'])->name('password.reset');
    Route::get('/email/verify',[RegisterController::class,'verifyEmail'])->name('verify.email');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');
});
