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
Route::get("/consultar", 'InventarioController@consultar');

use Illuminate\Http\Request;

Route::post('/inventario', function (Request $request) {
    $aula = $request->get('aula');
    $claveArticulo = explode("|",$request->get('articulo'));
    $validator = Validator::make($request->all(), [
        'aula' => 'required|unique:inventario,clave_instalacion,NULL,id,codigo_articulo,' . $claveArticulo[0],
        'articulo' => 'required|unique:inventario,codigo_articulo,NULL,id,clave_instalacion,' . $aula,
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
