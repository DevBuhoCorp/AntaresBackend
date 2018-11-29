<?php

namespace App\Http\Controllers;

use App\Models\Areacolab;
use App\Models\Detalleop;
use App\Models\Ordenpedido;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdenPedidoController extends Controller
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

                

                $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID'])[0];

                $ordenpedido = Ordenpedido::where('Estado', $request->input('Estado'))
                    ->where('IDAreaColab', $areacolab->ID)
                    ->paginate($request->input('psize'));

                return response()->json($ordenpedido, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function indexauth(Request $request)
    {
        try {
            if ($request->isJson()) {

                $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->join('cargo as cg','cg.ID','areacolab.IdCargo')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID','cg.Autorizar'])[0];
                
                if($areacolab->Autorizar == 1){
                    $ordenpedido = Ordenpedido::where('Estado', $request->input('Estado'))
                    ->paginate($request->input('psize'));
                    return response()->json($ordenpedido, 200);
                }
                else{
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                
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
                $carbon = new Carbon($request->input('FechaRegistro'));
                $opedido = new Ordenpedido();
                $opedido->FechaRegistro = $carbon->toDateString();
                $opedido->Estado = ($request->input('Estado'));
                $opedido->Observacion = ($request->input('Observacion'));
                $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID'])[0];

                $opedido->IDAreaColab = $areacolab->ID;

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
    public function show(Request $request, $id)
    {
        try {
            $detalle = Detalleop::where('IdOPedido', $id)->paginate($request->input('psize'));
            return response()->json($detalle, 200);
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
        try {
            if ($request->isJson()) {
                $opedido = Ordenpedido::find($id);
                $opedido->fill($request->all());
                if($opedido->Estado == 'ACT' || 'RCH'){
                    $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID'])[0];
                    $opedido->IDAutorizado = $areacolab->ID;
                    $opedido->FechaAutorizacion = Carbon::now('America/Guayaquil');
                }
                $opedido->save();
                return response()->json($opedido, 200);
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
