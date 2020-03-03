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

use App\Inventario;

Route::get("/", 'InventarioController@index');

use Illuminate\Http\Request;

Route::post('/inventario', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'aula' => 'required',
        'articulo' => 'required',
        'cantidadArticulos' => 'required|numeric|between:1,100',
        'fecha' => 'nullable|before_or_equal:' . date('Y-m-d'),
        'observaciones' => 'max:250'
    ]);
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $task = new Inventario;
    $task->clave_instalacion = $request->aula;
    $articulo = explode("|", $request->articulo);
    $task->codigo_articulo = $articulo[0];
    $task->articulo = $articulo[1];
    $task->cantidad = $request->cantidadArticulos;
    $task->fecha_compra = $request->fecha;
    $task->observaciones = $request->observaciones;
    $task->save();
    return redirect('/');
});

Route::post('/inventario/borrarinventario', 'InventarioController@deleteInventario');

/* 
Route::get('/', function () {
    return view('welcome');
}); */
