<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::post('/import-csv', [ProductController::class, 'importFromCsv']);

Route::post('/order', [OrderController::class, 'create']);
Route::get('/catalog/filter', [ProductController::class, 'filter']);
