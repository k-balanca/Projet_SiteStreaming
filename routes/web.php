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
})->name('welcome');

Route::get('/films', function () {
    return view('Films');
})->name('films');

Route::get('/series', function () {
    return view('series');
})->name('series');

Route::get('/favoris', function () {
    return view('favoris');
})->name('favoris');

Route::get('/compte', function () {
    return view('compte');
})->name('compte');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
