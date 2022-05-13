<?php

use App\Http\Controllers\AddContactToFavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeleteContactFromFavoriteController;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
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

Route::get('/test', function () {
    return 123;
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});


Route::prefix('/contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contacts');
    Route::get('/favorite', [ContactController::class, 'favorite'])->name('favorite_contacts');
    Route::get('/favorite/{id}', [ContactController::class, 'addToFavorite'])->name('add_contact');
    Route::delete('/favorite/{id}', [ContactController::class, 'deleteFromFavorite'])->name('delete_contact');
});
