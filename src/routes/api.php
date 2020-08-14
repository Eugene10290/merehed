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

//Auth
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\RegisterController@register');
//Authors
Route::get('authors', 'Api\AuthorsController@index');
Route::get('authors/{id}/books', 'Api\AuthorsController@getAuthorBooks');

//Books
Route::get('/books', 'Api\BooksController@index');

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('books/user', 'Api\BooksController@indexUser');
        Route::post('books/create', 'Api\BooksController@store');
        Route::post('books/{id}/edit', 'Api\BooksController@update');
        Route::delete('books/{id}', 'Api\BooksController@destroy');
    }
);

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
