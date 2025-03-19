<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::get('/student/{studentId}', [StudentController::class, 'show'])
    ->middleware('auth:sanctum');;
Route::post('/student', [StudentController::class, 'store']);
Route::put('/student/{studentId}', [StudentController::class, 'update']);
Route::delete('/student/{studentId}', [StudentController::class, 'delete']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);