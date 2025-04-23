<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

Route::get('/clients', [ClientController::class, 'read']);
Route::post('create-client',[ClientController::class, 'create']);
Route::get('/clients/edit/{id}', [ClientController::class, 'showUpdateForm']);
Route::post('clients/edit/update-client/{id}', [ClientController::class, 'update']);
Route::delete('clients/delete/{id}', [ClientController::class, 'delete']);
