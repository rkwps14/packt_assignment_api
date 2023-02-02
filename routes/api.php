<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController,BooksController};

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

Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // return $request->user();

// });

Route::group(['prefix'=>'admin','middleware'=>'auth:sanctum','namespace'=>'admin'],function(){
    Route::get('users', [UserController::class, 'getUsers']);
    Route::get('users/edit/{id}', [UserController::class, 'getEditUsers']);
    Route::post('users/update/{id}', [UserController::class, 'getUpdateUsers']);
    Route::get('all-users', [UserController::class, 'getAllUser']);
    Route::get('all-books', [BooksController::class, 'index']);
    Route::post('store-books', [BooksController::class, 'store']);
    Route::get('store-books/{id}', [BooksController::class, 'edit']);
    Route::post('store-books/{id}', [BooksController::class, 'update']);
    Route::get('store-books/delete/{id}', [BooksController::class, 'destroy']);
});
