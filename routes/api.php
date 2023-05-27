<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

Route::post('/name-is-free', [UserController::class, 'nameIsFree']);
Route::post('/email-is-free', [UserController::class, 'emailIsFree']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/logout', [UserController::class, 'logout']);

  Route::get('/user', [UserController::class, 'index']);

  Route::get('/tasks', [TaskController::class, 'list']);
  Route::get('/tasks/counter', [TaskController::class, 'counter']);
  Route::post('/tasks', [TaskController::class, 'store']);
  Route::post('/tasks/{id}/completing', [TaskController::class, 'completing']);
  Route::post('/tasks/{id}/updating-title', [TaskController::class, 'updatingTitle']);
  Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});
