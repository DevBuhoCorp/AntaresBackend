<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Detallecotizacion;
use App\Models\Detalleop;
use App\Models\Ordenpedido;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CotizacionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->isJson()) {
                $cotizacion = Cotizacion::where('Estado',$request->input('Estado'))->paginate($request->input('psize'));
                return response()->json($cotizacion, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
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
        try {
            if ($request->isJson()) {
                $fechainicio = new Carbon($request->input('FechaIni'));
                $fechafin = new Carbon($request->input('FechaFin'));
                $cotizacion = new Cotizacion();
                $cotizacion->FechaIni = $fechainicio->toDateString();
                $cotizacion->FechaFin = $fechafin->toDateString();
                $cotizacion->FechaReg = Carbon::now('America/Guayaquil');
                $cotizacion->Estado = $request->input('Estado');
                $cotizacion->Observacion = $request->input('Observacion');
                $cotizacion->save();
                foreach ($request->all()['Detalles'] as $id) {
                    $detallesop = Detalleop::where('IdOPedido', $id)->get(['ID']);
                    foreach ($detallesop as $detalleop) {
                        $detalle = new Detallecotizacion();
                        $detalle->IDCotizacion = $cotizacion->ID;
                        $detalle->IDDetalleordenpedido = $detalleop->ID;
                        $detalle->Estado = $cotizacion->Estado;
                        $detalle->save();
                    }

                    $ordenpedido = Ordenpedido::find($id);
                    $ordenpedido->Estado = 'EMT'; //Estado a Emitido
                    $ordenpedido->save();

                }
                return response()->json(true, 201);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $detallecotizacion = Detallecotizacion::where('IdCotizacion',$id)->get();
            $array = [];
            foreach ($detallecotizacion as $detalle) {
                
                $detalleop = Detalleop::find($detalle->IDDetalleordenpedido);
                array_push($array, $detalleop);
                
            }
           // $detalleop->paginate($request->input('psize'));
            return response()->json($array, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
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
        //
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
