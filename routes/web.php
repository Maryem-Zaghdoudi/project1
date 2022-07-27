<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;

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
Route::resource ('services', ServiceController::class);


//Route::post('/recherche', [ServiceController::class, 'recherche'])->name('services.recherche');
Route::post('/search', [ServiceController::class, 'search'])->name('services.search');


Route::resource ('categories', CategorieController::class);




