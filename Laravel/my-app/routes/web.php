<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('home');
});

Route::get('/test', [TestController::class, 'test']);
