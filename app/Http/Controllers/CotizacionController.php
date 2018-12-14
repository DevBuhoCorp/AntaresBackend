<?php

namespace App\Http\Controllers;

use App\Models\Areacolab;
use App\Models\Cotizacion;
use App\Models\Detallecotizacion;
use App\Models\Detallecotizacionproveedor;
use App\Models\Detalleop;
use App\Models\Ordenpedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

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
                $cotizacion = Cotizacion::where('Estado', $request->input('Estado'))->paginate($request->input('psize'));
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
                $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                    ->join('cargo as cg', 'cg.ID', 'areacolab.IdCargo')
                    ->where('c.IDUsers', $request->user()->id)
                    ->get(['areacolab.ID', 'cg.Autorizar'])[0];
                $fechainicio = new Carbon($request->input('FechaIni'));
                $fechafin = new Carbon($request->input('FechaFin'));
                $cotizacion = new Cotizacion();
                $cotizacion->FechaIni = $fechainicio->toDateString();
                $cotizacion->FechaFin = $fechafin->toDateString();
                $cotizacion->FechaReg = Carbon::now('America/Guayaquil');
                $cotizacion->Estado = $request->input('Estado');
                $cotizacion->Observacion = $request->input('Observacion');
                $cotizacion->IDAreaColab = $areacolab->ID;
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
                    $ordenpedido->Estado = 'COT'; //Estado a Emitido
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

            $detallecotizacion = Detallecotizacion::where('IdCotizacion', $id)->get();
            $array = [];
            foreach ($detallecotizacion as $detalle) {
                $detalleop = Detalleop::find($detalle->IDDetalleOrdenpedido)->join('ordenpedido as op', 'op.ID', 'detalleop.IdOPedido')->select('detalleop.*', 'op.Observacion as OrdenPedido')->get();
                //array_push($array, $detalleop);
            }
            return response()->json($detalleop, 200);
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

    public function email(Request $request)
    {
        $cotizacion = Cotizacion::find($request->input('cotizacion'));
        $cotizacion->Estado = "ENV";
        $cotizacion->save(); 

        $detallecot = Detallecotizacion::where('IDCotizacion', $cotizacion->ID)->get();
        $data = array();
        foreach ($detallecot as $detalle) {
            foreach ($request->input('proveedor') as $proveedor) {
                $bandera = Detallecotizacionproveedor::where('IDDetallecotizacion', $detalle->ID)->where('IDProveedor', $proveedor)->get();
                if (count($bandera) == 0) {
                    $detalleprov = new Detallecotizacionproveedor();
                    $detalleprov->IDDetallecotizacion = $detalle->ID;
                    $detalleprov->IDProveedor = $proveedor;
                    $detalleprov->save();
                }

            }
        }

        ExportController::exportCotizacion($request->input('cotizacion'));
       // ExportController::exportRespuesta($request->input('cotizacion'));
        $data = array('mensaje' => $request->input('message'));
        Mail::send('cotizacion', $data, function ($message) use ($request) {
        $file1 = Excel::load('storage/exports/Cotizacion.xlsx');
        $file2 = Excel::load('storage/exports/Respuesta.xlsx');

        $message->to($request->input('to'))
        ->subject($request->input('subject'))
        ->attach($file1->store("xlsx", false, true)['full'])
        ->attach($file2->store("xlsx", false, true)['full']);

        }); 

        return response()->json(true, 200);

    }

}
