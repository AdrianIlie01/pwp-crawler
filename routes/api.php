<?php

use App\Http\Controllers\CrawlerController;
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

Route::get('crawler',[CrawlerController::class,'crawler']);

Route::post('storeCategories',[CrawlerController::class,'storeCategories']);
Route::post('storeSubcategories',[CrawlerController::class,'storeSubcategories']);
Route::post('attach/{categoryId}/{subcategoryId}',[CrawlerController::class,'attach']);

Route::delete('deleteCategory/{id}',[CrawlerController::class,'deleteCategory']);
Route::delete('deleteSubcategory/{id}',[CrawlerController::class,'deleteSubcategory']);

