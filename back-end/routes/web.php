<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\VendedorController;

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

Route::get('/api/list/vendedores', [VendedorController::class,  'show']);
Route::post('/api/create/vendedor', [VendedorController::class, 'create']);
Route::post('/api/delete/vendedor', [VendedorController::class, 'destroy']);

Route::get('/api/list/vendas', [VendaController::class, 'show']);
Route::post('/api/create/venda', [VendaController::class, 'create']);
Route::post('/api/delete/venda', [VendaController::class, 'destroy']);
Route::post('/api/sendmail', [VendaController::class, 'sendmail']);