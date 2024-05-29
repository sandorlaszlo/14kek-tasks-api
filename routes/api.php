<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/tasks', [TaskController::class, 'index']);
// Route::get('/tasks/{task}', [TaskController::class, 'show']);
// Route::post('/tasks', [TaskController::class,'store']);
// Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
// Route::put('/tasks/{task}', [TaskController::class, 'update']);
// Route::patch('/tasks/{task}', [TaskController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::get('/tasks/published/all', [TaskController::class, 'published']);
    Route::get('/tasks/published/{task}', [TaskController::class, 'showPublished']);
});


Route::post('login', [AuthController::class, 'login']);