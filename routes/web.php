<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('{any?}', fn () => view('app'))->where('any', '.*');
Route::post('/api/add_url', [UrlController::class, 'addUrl']);
Route::post('/api/get_shorten_urls', [UrlController::class, 'getShortenUrls']);
