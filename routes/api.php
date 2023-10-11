<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

/* AuthController */
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('user/{user}', [UserController::class, 'show']);

/* Middleware */
Route::middleware(['auth:sanctum'])->group(function () {
  /* AuthController */
  Route::post('logout', [AuthController::class, 'logout']);

  /* TravelController */
  Route::get('travel', [TravelController::class, 'index']);
  Route::get('travel/{id}', [TravelController::class, 'show']);
  Route::put('travel/{id}', [TravelController::class, 'update']);

  /* TravelUserController */
});
