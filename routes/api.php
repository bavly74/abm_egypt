<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/tasks',[TaskController::class,'index'])->middleware('auth:sanctum');
Route::post('/tasks',[TaskController::class,'store'])->middleware('auth:sanctum');
Route::put('/tasks/{task}',[TaskController::class,'update'])->middleware('auth:sanctum');
Route::delete('/tasks/{task}',[TaskController::class,'destroy'])->middleware('auth:sanctum');
