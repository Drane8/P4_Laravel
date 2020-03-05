<?php

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

use App\Http\Controllers\InventarioController;
use App\Inventario;
use Illuminate\Http\Request;

Route::get("/", 'InventarioController@index');

Route::post('/inventario', 'InventarioController@insertar');

Route::get("/consultar", 'InventarioController@consultar');

Route::post("/consultar",'InventarioController@consultarInventarios');

Route::post('/inventario/borrarinventario', 'InventarioController@deleteInventario');

/* 
Route::get('/', function () {
    return view('welcome');
}); */
