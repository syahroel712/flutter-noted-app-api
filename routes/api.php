<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\FolderController;
use App\Http\Controllers\Api\NoteController;
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
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    
    // logout
    Route::get('logout', [PassportAuthController::class, 'logout']);

    // user
    Route::get('user', [PassportAuthController::class, 'index']);
    Route::post('/user', [PassportAuthController::class, 'store']);
    Route::get('/user/{id}', [PassportAuthController::class, 'show']);
    Route::put('/user/{user}', [PassportAuthController::class, 'update']);
    Route::delete('/user/{user}', [PassportAuthController::class, 'destroy']);

    // folder
    Route::get('/folder', [FolderController::class, 'index']);
    Route::post('/folder', [FolderController::class, 'store']);
    Route::get('/folder/{id}', [FolderController::class, 'show']);
    Route::put('/folder/{folder}', [FolderController::class, 'update']);
    Route::delete('/folder/{folder}', [FolderController::class, 'destroy']);

    // note
    Route::get('/note', [NoteController::class,'index']);
    Route::post('/note', [NoteController::class,'store']);
    Route::get('/note/{id}', [NoteController::class,'show']);
    Route::put('/note/{note}', [NoteController::class,'update']);
    Route::delete('/note/{note}', [NoteController::class,'destroy']);

});
