<?php

use App\Http\Controllers\CrawlerController;
use App\Http\Controllers\ScrapingController;
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
//Route::get('view', 'App\Http\Controllers\CrawlerControler@view');

Route::get('crawler',[CrawlerController::class,'crawler']);
Route::get('announces',[CrawlerController::class,'announces']);
Route::get('dropDown',[CrawlerController::class,'dropDown']);



Route::get('scraping',[ScrapingController::class,'scraping']);
