<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', function () {
    return view('example');
});

Route::get('/{any}', function () {
    return view('app'); // Certifique-se de que 'app.blade.php' está correto
})->where('any', '.*');

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::put('/products', [ProductController::class, 'update']);


Route::post('/order', [OrderController::class, 'create']);
