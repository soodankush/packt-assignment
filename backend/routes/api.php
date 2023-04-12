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

Route::get('/faker/books', 'App\Http\Controllers\BookController@getBooksFromFaker');

Route::prefix('books')->group(function () {
    Route::get('/', 'App\Http\Controllers\BookController@index');
    Route::get('/{bookId}', 'App\Http\Controllers\BookController@getBookById');
    Route::post('/', 'App\Http\Controllers\BookController@store');
    Route::put('/{bookId}', 'App\Http\Controllers\BookController@update');
    Route::delete('/{bookId}', 'App\Http\Controllers\BookController@delete');
});
