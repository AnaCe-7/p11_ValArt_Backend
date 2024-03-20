<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\ImageController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([], function(){
    Route::get('/', [ArtworkController::class, 'index']);
    Route::post('/artwork', [ArtworkController::class, 'store']);
    Route::get('/artwork/{id}', [ArtworkController::class, 'show']);
    Route::put('/artwork/{id}', [ArtworkController::class, 'update']);
    Route::delete('/artwork/{id}', [ArtworkController::class, 'destroy']);
});

Route::group([], function(){
    Route::get('/', [ImageController::class, 'index']);
    Route::post('/artwork', [ImageController::class, 'store']);
    Route::get('/artwork/{id}', [ImageController::class, 'show']);
    Route::put('/artwork/{id}', [ImageController::class, 'update']);
    Route::delete('/artwork/{id}', [ImageController::class, 'destroy']);
});