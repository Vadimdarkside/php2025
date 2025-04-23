<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrainerController;

Route::get('/', function () {
    return view('home');
});

Route::get('/clients', [ClientController::class, 'read']);
Route::post('create-client',[ClientController::class, 'create']);
Route::get('/clients/edit/{id}', [ClientController::class, 'showUpdateForm']);
Route::post('clients/edit/update-client/{id}', [ClientController::class, 'update']);
Route::delete('clients/delete/{id}', [ClientController::class, 'delete']);

Route::get('/trainers', [TrainerController::class, "read"]);
Route::post('create-trainer',[TrainerController::class, 'create']);
Route::get('/trainers/edit/{id}', [TrainerController::class, 'showUpdateForm']);
Route::post('trainers/edit/update-trainer/{id}', [TrainerController::class, 'update']);
Route::delete('trainers/delete/{id}', [TrainerController::class, 'delete']);
