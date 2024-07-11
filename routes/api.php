<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// importing another api file
require __DIR__.'/auth.php';

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


