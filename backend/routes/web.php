<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faker/books', 'App\Http\Controllers\BookController@getBooksFromFaker');

Route::prefix('books')->group(function () {
    Route::get('/', 'App\Http\Controllers\BookController@index');
});
