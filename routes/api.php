<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

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
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profiles', [ProfileController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/profiles/{profile}/comments', [CommentController::class, 'store']);
    Route::get('/all-profiles', [ProfileController::class, 'indexAll']);
});
