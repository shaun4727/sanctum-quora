<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Space\SpaceController;

// importing another api file
require __DIR__.'/auth.php';

Route::get('/user', function (Request $request) {
    return $request->user()->makeHidden('email_token');
})->middleware('auth:sanctum');

Route::prefix('profile')->group(function(){
    Route::post('/employment-credential', [ProfileController::class,'createEmploymentCredential'])->middleware('auth:sanctum');
    Route::post('/educational-credential', [ProfileController::class,'createEducationalCredential'])->middleware('auth:sanctum');
    Route::post('/location-detail', [ProfileController::class,'createLocationDetail'])->middleware('auth:sanctum');
    Route::post('/upload-profile-photo', [ProfileController::class,'uploadProfilePhoto'])->middleware('auth:sanctum');
    Route::get('/credential-detail/{user_id}', [ProfileController::class,'getCredentialDetail'])->middleware('auth:sanctum');
});


Route::prefix('space')->group(function(){
    Route::post('/create-space', [SpaceController::class,'createSpace'])->middleware('auth:sanctum');
    Route::get('/get-spaces',[SpaceController::class,'getAllSpaces'])->middleware('auth:sanctum');
});