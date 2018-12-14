<?php

namespace App\Http\Controllers;

use App\Models\Detallecotizacionproveedor;
use Illuminate\Http\Request;
use App\Models\Detallecotizacion;

class DetCotizacionProvController extends Controller
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
                $detallescot = Detallecotizacion::where('IDCotizacion', $request->input('IDCotizacion'))->select('ID')->get();
                $detallesprov = [];
                for ($i = 0; $i < count($detallescot); $i++) {
                    $detalle = new Detallecotizacionproveedor();
                    $detalle = Detallecotizacionproveedor::join('detallecotizacion as dc', 'IDDetallecotizacion', '=', 'dc.ID')
                        ->join('detalleop as op', 'dc.IDDetalleOrdenpedido', '=', 'op.ID')
                        ->where('detallecotizacionproveedor.IDProveedor', $request->input('IDProveedor'))
                        ->where('detallecotizacionproveedor.IDDetallecotizacion', $detallescot[$i]->ID)
                        ->select('detallecotizacionproveedor.ID', 'detallecotizacionproveedor.Etiqueta', 'op.Cantidad as CantidadDeseada', 'detallecotizacionproveedor.Cantidad', 'detallecotizacionproveedor.Precio')
                        ->first();
                    array_push($detallesprov, $detalle);
                }
                return response()->json($detallesprov, 200);
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
                foreach ($request->all() as $detalle) {
                    
                        $upd = Detallecotizacionproveedor::find($detalle["ID"]);
                        $upd->fill($detalle);
                        $upd->save();
                    
                    }

                }
                return response()->json($upd, 200);
            
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
    public function update(Request $request)
    {
       
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
