<?php

namespace App\Http\Controllers;

use App\Models\Detallecotizacion;
use Illuminate\Http\Request;
use App\Models\Cotizacion;

class DetalleCotController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if ($request->isJson()) {
                $detallescotizacion = Detallecotizacion::where('IDCotizacion', $id)->get();
                
                $count = 0;
                foreach ($detallescotizacion as $detalle) {
                    $detalle->IDProveedor = $request->all()['Detalle'][$count];
                    $detalle->save();
                    $count++;
                }

                $cotizacion = Cotizacion::find($id);
                $fechainicio = new Carbon($request->input('FechaIni'));
                $fechafin = new Carbon($request->input('FechaFin'));
                $cotizacion = Cotizacion::find($id);
                $cotizacion->FechaIni = $fechainicio->toDateString();
                $cotizacion->FechaFin = $fechafin->toDateString();
                //$cotizacion->FechaReg = Carbon::now('America/Guayaquil'); Aumentar Fecha Edición?
                //$cotizacion->Estado = $request->input('Estado');
                $cotizacion->Observacion = $request->input('Observacion');
                $cotizacion->save();

                return response()->json(true, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
