<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);

Route::put('/products/{id}', [ProductController::class, 'update']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/products/{productId}/upload-image', [ProductController::class, 'uploadImage']);
Route::post('/import-csv', [ProductController::class, 'importFromCsv']);

Route::post('/login', [AuthController::class, 'login']);


Route::post('/order', [OrderController::class, 'create']);
Route::get('/catalog/filter', [ProductController::class, 'filter']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/all', [CategoryController::class, 'all']);
Route::post('/categories', [CategoryController::class, 'store']);

Route::get('/brands', [BrandController::class, 'index']);
Route::put('/brands/{id}', [BrandController::class, 'update']);
Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
Route::post('/brands', [BrandController::class, 'store']);

Route::get('/orders', [OrderController::class, 'index']);

