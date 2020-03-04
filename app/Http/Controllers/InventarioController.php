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
    public function index()
    {
        $inventarios = Inventario::all();
        $instalaciones = Instalacion::all();
        $articulos = Articulo::all();
        return view('insertar', ['inventarios' => $inventarios, 'instalaciones' => $instalaciones, 'articulos' => $articulos]);

        
    }

    public function consultar()
    {
        $instalaciones = Instalacion::all();
        return view('consultar', ['instalaciones' => $instalaciones]);
    }

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
