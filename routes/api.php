<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/student/{studentId}', [StudentController::class, 'show']);
Route::post('/student', [StudentController::class, 'store']);
Route::put('/student/{studentId}', [StudentController::class, 'update']);
Route::delete('/student/{studentId}', [StudentController::class, 'delete']);