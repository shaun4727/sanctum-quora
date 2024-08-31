<?php

use Illuminate\Support\Facades\Route;
use App\Events\NotificationProcessed;

Route::get('/', function () {
    broadcast(new NotificationProcessed());
    return view('welcome');
});

Route::get('/login', function(){
    return 'Login';
})->name('login');
