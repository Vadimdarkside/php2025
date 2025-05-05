<?php
use App\Controller\PaymentController;
use App\Controller\TrainerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WorkoutController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('clients', [ClientController::class, 'index']);     
    Route::post('clients', [ClientController::class, 'store']);       
    Route::get('clients/{id}', [ClientController::class, 'show']); 
    Route::put('clients/{id}', [ClientController::class, 'update']); 
    Route::delete('clients/{id}', [ClientController::class, 'destroy']); 
});

Route::middleware('auth:api', 'role:admin')->prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'read']);
    Route::post('/', [PaymentController::class, 'create']);
    Route::get('{id}', [PaymentController::class, 'showUpdateForm']);
    Route::put('{id}', [PaymentController::class, 'update']);
    Route::delete('{id}', [PaymentController::class, 'delete']);
});


Route::middleware('auth:api')->prefix('trainers')->group(function () {
    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/', [TrainerController::class, 'read']);
        Route::post('/', [TrainerController::class, 'create']);
        Route::put('{id}', [TrainerController::class, 'update']);
        Route::delete('{id}', [TrainerController::class, 'delete']);
    });
});

Route::middleware('auth:api')->prefix('programs')->group(function () {
    Route::get('/', [WorkoutController::class, 'read']);
    Route::post('/', [WorkoutController::class, 'create'])->middleware('checkUserRole');
    Route::put('{id}', [WorkoutController::class, 'update'])->middleware('checkUserRole');
    Route::delete('{id}', [WorkoutController::class, 'delete'])->middleware('checkUserRole');
});