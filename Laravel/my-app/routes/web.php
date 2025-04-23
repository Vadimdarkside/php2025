<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\PaymentController;

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

Route::get('/programs', [WorkoutController::class, "read"]);
Route::post('create-program',[WorkoutController::class, 'create']);
Route::get('/programs/edit/{id}', [WorkoutController::class, 'showUpdateForm']);
Route::post('programs/edit/update-program/{id}', [WorkoutController::class, 'update']);
Route::delete('programs/delete/{id}', [WorkoutController::class, 'delete']);

Route::get('/enrolls', [EnrollmentController::class, "read"]);
Route::post('create-enroll',[EnrollmentController::class, 'create']);
Route::get('/enrolls/edit/{id}', [EnrollmentController::class, 'showUpdateForm']);
Route::post('enrolls/edit/update-enroll/{id}', [EnrollmentController::class, 'update']);
Route::delete('enrolls/delete/{id}', [EnrollmentController::class, 'delete']);

Route::get('/payments', [PaymentController::class, "read"]);
Route::post('create-payment',[PaymentController::class, 'create']);
Route::get('/payments/edit/{id}', [PaymentController::class, 'showUpdateForm']);
Route::post('payments/edit/update-payment/{id}', [PaymentController::class, 'update']);
Route::delete('payments/delete/{id}', [PaymentController::class, 'delete']);