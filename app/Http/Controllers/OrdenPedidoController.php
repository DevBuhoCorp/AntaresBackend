<?php

namespace App\Http\Controllers;

use App\Models\Detalleop;
use App\Models\Ordenpedido;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Areacolab;

class OrdenPedidoController extends Controller
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
        try {
            if ($request->isJson()) {
                $carbon = new Carbon($request->input('FechaRegistro'));
                $opedido = new Ordenpedido();
                $opedido->FechaRegistro = $carbon->toDateString();
                $opedido->Estado = ($request->input('Estado'));
                $opedido->Observacion = ($request->input('Observacion'));
                //return $request->user();
                $areacolab = Areacolab::join('colaborador as c','c.ID','areacolab.IdColaborador')
                ->where('c.IDUsers',$request->user()->id)
                ->get(['areacolab.ID'])[0];

                $opedido->IDAreaColab = $areacolab;

                $opedido->save();
                foreach ($request->all()['Detalles'] as $detalle) {
                    $detalle = new Detalleop($detalle);
                    $detalle->IdOPedido = $opedido->ID;
                    $detalle->save();
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
