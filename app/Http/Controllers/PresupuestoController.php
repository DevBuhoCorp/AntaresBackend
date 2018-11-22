<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $departamento, $anio)
    {
        try {
            $presupuesto = Presupuesto::where('IDDepartamento', $departamento)->where('Anio', $anio)->first();
            if( $presupuesto ){
                $presupuesto->fill( $request->all() );
            }else{
                $presupuesto = new Presupuesto( $request->all() );
            }
            $presupuesto->save();
            return response()->json($presupuesto, 200);


        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $departamento, $anio)
    {
        $data = [
            "Row" => Presupuesto::where('IDDepartamento', $departamento)->where('Anio', $anio)->first(),
            "extra" => [
                "OPedido" => 0,
                "OCompra" => 0,
                "Compras" => 0
            ]

        ];
//        $data = Presupuesto::where('IDPresupuesto', $departamento)->where('Anio', $departamento)->first();
        return Response($data, 200);
    }
}
