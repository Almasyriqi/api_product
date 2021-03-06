<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductAssetController;
use App\Http\Controllers\API\ProductController;
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

// Endpoint Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/order', [CategoryController::class, 'orderByAmountProduct']);

// Endpoint Products
Route::get('product/order', [ProductController::class, 'orderByPrice']);
Route::apiResource('product', ProductController::class);

// Endpoint Product Asset
Route::apiResource('productAsset', ProductAssetController::class);
