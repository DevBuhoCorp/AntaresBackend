<?php

namespace App\Http\Controllers;

use App\Models\Areacolab;
use App\Models\Detallecotizacionproveedor;
use App\Models\Ordencompra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrdenCompraController extends Controller
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
                
                $ocompra = Ordencompra::join('proveedor as p','p.ID','ordencompra.IDProveedor')
                ->join('areacolab as ac','ac.ID','ordencompra.IDAreaColab')
                ->join('colaborador as c','c.ID','ac.IdColaborador')
                ->join('modospago as mp','mp.ID','ordencompra.IDModoPago')
                ->join('condicionespago as cp','cp.ID','ordencompra.IDCondicionPago')
                ->where('ordencompra.Estado',$request->input('Estado'))
                ->select('ordencompra.ID','ordencompra.FechaRegistro','p.RazonSocial',DB::raw("CONCAT(c.NombrePrimero,' ',c.ApellidoPaterno) as Nombre"),'ordencompra.FechaEntrega','ordencompra.Observacion','mp.Etiqueta as ModoPago','cp.Etiqueta as CondicionPago')
                ->paginate($request->input('psize'));

                return response()->json($ocompra, 200);
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
                $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->join('cargo as cg', 'cg.ID', 'areacolab.IdCargo')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID', 'cg.Autorizar'])[0];
                $fechaentrega = new Carbon($request->input('FechaEntrega'));
                $ordencompra = new Ordencompra();
                $ordencompra->FechaRegistro = Carbon::now('America/Guayaquil');
                $ordencompra->Estado = "BRR";
                $ordencompra->IDAreaColab = $areacolab->ID;
                $ordencompra->FechaEntrega = $fechaentrega->toDateString();
                $ordencompra->IDProveedor = $request->input('IDProveedor');
                $ordencompra->Observacion = $request->input('Observacion');
                $ordencompra->IDModoPago = $request->input('IDModoPago');
                $ordencompra->IDCondicionPago = $request->input('IDCondicionPago');
                $ordencompra->save();
                $ordencompra->detalleordencompras()->createMany($request->all()['Detalles']);
                $detalleprov = Detallecotizacionproveedor::find($request->all()['IDCotProv']); 
                $detalleprov->Estado = "BRR";
                $detalleprov->each(function ($detalle) {
                    $detalle->Estado = "ACT";
                    $detalle->save();
                });

                return response()->json($detalleprov, 201);
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

    public function itemscompra(Request $request)
    {
        try {
            $items = Detallecotizacionproveedor::join('detallecotizacion as dc', 'dc.ID', 'detallecotizacionproveedor.IDDetallecotizacion')
                ->join('cotizacion as c', 'c.ID', 'dc.IDCotizacion')
                ->join('detalleop as dop', 'dop.ID', 'dc.IDDetalleOrdenpedido')
                ->join('ordenpedido as op', 'op.ID', 'dop.IdOPedido')
                ->where('detallecotizacionproveedor.IDProveedor', $request->input('IDProveedor'))
                ->where('detallecotizacionproveedor.Estado', $request->input('Estado'))
                ->select('detallecotizacionproveedor.ID', 'c.Observacion as Cotizacion', 'detallecotizacionproveedor.Etiqueta as Descripcion', 'detallecotizacionproveedor.Cantidad', 'detallecotizacionproveedor.Precio', 'op.Observacion as OrdenPedido', 'op.ID as IDDetalleordenpedido')
                ->get();

            return response()->json($items, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }

    }

}
