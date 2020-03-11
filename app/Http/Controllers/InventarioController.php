<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//PREGUNTAR A KARMELE
use Illuminate\Support\Facades\Validator;

use App\Inventario;
use App\Instalacion;
use App\Articulo;

class InventarioController extends Controller
{

    /**
     * Funcion para mostrar la vista insertar
     *
     */
    public function index()
    {
        $inventarios = Inventario::all();
        $instalaciones = Instalacion::all();
        $articulos = Articulo::all();
        return view('insertar', ['inventarios' => $inventarios, 'instalaciones' => $instalaciones, 'articulos' => $articulos]);
    }


    /**
     * Esta funcion se encarga de recoger los datos del formulario
     * validarlos y, si estan correctos, introducirlos en la base de datos
     *
     */
    public function insertar(Request $request)
    {
        $aula = $request->get('aula');
        $claveArticulo = explode("|", $request->get('articulo'));
        $validator = Validator::make($request->all(), [
            'aula' => 'required|unique:inventario,clave_instalacion,NULL,NULL,codigo_articulo,' . $claveArticulo[0],
            'articulo' => 'required|unique:inventario,codigo_articulo,NULL,NULL,clave_instalacion,' . $aula,
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
    }

/**
     * Funcion para mostrar la vista consultar
     *
     */
    public function consultar()
    {
        $instalaciones = Instalacion::all();
        return view('consultar', ['instalaciones' => $instalaciones]);
    }

    /**
     * Muestra los inventarios seleccionados del formulario
     * que han sido validados previamente
     *
     */
    public function consultarInventarios(Request $request){
        $validator = Validator::make($request->all(),[
            'aulas' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('/consultar')
                ->withInput()
                ->withErrors($validator);
        }
        $inventarios = Inventario::all()->whereIN('clave_instalacion', $request->aulas);

        if(count($inventarios)==0){
            $validator->errors()->add('aulas', 'No hay registro para las aulas seleccionadas');
            return redirect('/consultar')
                ->withInput()
                ->withErrors($validator);
        }

        $instalaciones = Instalacion::all();
        return view('/consultar',['instalaciones' => $instalaciones, 'inventarios' => $inventarios]);
    }



    /**
     * Se encarga de borrar un registro de la base de datos
     *
     */
    public function deleteInventario(Request $request)
    {
        $rules = [
            'clave_instalacion' => 'string',
            'codigo_articulo' => 'integer'
        ];
        $validator = Validator::make($request->only(['clave_instalacion', 'codigo_articulo']), $rules);
        if ($validator->fails()) {
            return redirect('/')->withErrors($validator);
        } else {
            if (Inventario::where('clave_instalacion', '=', $request->clave_instalacion)
                ->where('codigo_articulo', '=', $request->codigo_articulo)->delete()
            ) {
                return redirect('/');
            }
        }
    }
}
