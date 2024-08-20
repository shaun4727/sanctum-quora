<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Profile\ProfileController;

// importing another api file
require __DIR__.'/auth.php';

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('profile')->group(function(){
    Route::post('/employment-credential', [ProfileController::class,'createEmploymentCredential'])->middleware('auth:sanctum');
});
