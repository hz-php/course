<?php

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

Route::post('/register', 'App\Http\Controllers\Auth\UserAuthController@register');
Route::post('/login', 'App\Http\Controllers\Auth\UserAuthController@login');

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/catalog/', [\App\Http\Controllers\Api\V1\HomeController::class, 'index']);
    Route::get('/catalog/{id}', [\App\Http\Controllers\Api\V1\HomeController::class, 'show']);
    Route::post('/catalog/add', [\App\Http\Controllers\Api\V1\HomeController::class, 'store']);
    Route::patch('/catalog/update/{id}', [\App\Http\Controllers\Api\V1\HomeController::class, 'update']);
    Route::delete('/catalog/delete/{id}', [\App\Http\Controllers\Api\V1\HomeController::class, 'destroy']);
});

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/favorite/', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'index']);
    Route::get('/faforite/{id}', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'show']);
    Route::post('/favorite/add', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'store']);
    Route::delete('favorite/delete', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'destroy']);
});

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/compare', [\App\Http\Controllers\Api\V1\CompareController::class, 'index']);
    Route::post('/compare/add', [\App\Http\Controllers\Api\V1\CompareController::class, 'store']);
    Route::delete('/compare/destroy', [\App\Http\Controllers\Api\V1\CompareController::class, 'destroy']);
    Route::delete('/compare/del', [\App\Http\Controllers\Api\V1\CompareController::class, 'deleteOne']);
});
