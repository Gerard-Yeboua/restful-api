<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login','App\Http\Controllers\UserController@login');
Route::post('register','App\Http\Controllers\UserController@register');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('authors', 'App\Http\Controllers\AuthorController');
    Route::GET('authors/search/{term}', 'App\Http\Controllers\AuthorController@search');

    Route::apiResource('book', 'App\Http\Controllers\BookController');
});
