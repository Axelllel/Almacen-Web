<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Web Almacén
|--------------------------------------------------------------------------
*/

// Home / Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// Productos
Route::prefix('productos')->name('products.')->group(function () {
    Route::get('/',       [ProductController::class, 'index'])->name('index');
    Route::get('/nuevo',  [ProductController::class, 'create'])->name('create');
    Route::post('/',      [ProductController::class, 'store'])->name('store');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

// Salidas
Route::prefix('salidas')->name('exits.')->group(function () {
    Route::get('/nuevo', [ExitController::class, 'create'])->name('create');
    Route::post('/',     [ExitController::class, 'store'])->name('store');
});

// Usuarios
Route::prefix('usuarios')->name('users.')->group(function () {
    Route::get('/nuevo',     [UserController::class, 'create'])->name('create');
    Route::post('/',         [UserController::class, 'store'])->name('store');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});
