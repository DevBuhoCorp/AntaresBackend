<?php

namespace App\Http\Controllers;

use App\Models\Areacolab;
use App\Models\Cotizacionproveedor;
use App\Models\Detallecotizacion;
use App\Models\Detallecotizacionproveedor;
use App\Models\Detalleop;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Exception;
use App\Models\Detalleordencompra;

class ExportController extends Controller
{

    public static function exportCotizacion($cotizacion)
    {
        try {
            if (true) {

                $opedidos = Detalleop::join('detallecotizacion as dc', 'dc.IDDetalleOrdenPedido', 'detalleop.ID')
                    ->join('detallecotizacionproveedor as dp', 'dc.ID', 'dp.IDDetallecotizacion')
                    ->join('cotizacion as c', 'dc.IDCotizacion', 'c.ID')
                    ->join('areacolab as ac', 'c.IDAreaColab', 'ac.ID')
                    ->join('colaborador as cl', 'ac.IdColaborador', 'cl.ID')
                    ->where('c.ID', $cotizacion)
                    ->select('detalleop.*', 'c.FechaIni', 'c.FechaFin', DB::raw("concat(cl.NombrePrimero, ' ', cl.NombreSegundo, ' ', cl.ApellidoPaterno, ' ', cl.ApellidoMaterno) as Colaborador"), 'dp.Referencia')->get();

                Excel::load('app/Files/Cotizacion.xlsx', function ($reader) use ($opedidos) {

                    $sheet = $reader->getActiveSheet();
                    $sheet->setCellValue('F' . 3, $opedidos[0]->FechaIni);
                    $sheet->setCellValue('F' . 4, $opedidos[0]->FechaFin);
                    $sheet->setCellValue('A' . 10, $opedidos[0]->Colaborador);
                    $row = 17;

                    foreach ($opedidos as $opedido) {

                        $sheet->setCellValue('A' . $row, $opedido->Etiqueta);
                        $sheet->setCellValue('C' . $row, $opedido->Cantidad);

                        $row++;

                    }

                })->store('xlsx');

                Excel::load('app/Files/Respuesta.xlsx', function ($reader) use ($opedidos) {
                    $sheet = $reader->getActiveSheet();
                    $row = 2;
                    foreach ($opedidos as $opedido) {
                        $sheet->setCellValue('A' . $row, $opedido->Referencia);
                        $sheet->setCellValue('B' . $row, $opedido->Etiqueta);
                        $row++;
                    }

                })->store('xlsx');
                return response()->json(true, 401);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public static function importCotizacion(Request $request)
    {
        try {
            $detallescot = Detallecotizacion::where('IDCotizacion', $request->input('IDCotizacion'))->select('ID')->get();
            $errors = "";
            $areacolab = Areacolab::join('colaborador as c', 'c.ID', 'areacolab.IdColaborador')
                ->where('c.IDUsers', $request->user()->id)
                ->first(['areacolab.ID']);

            $cotproveedor = Cotizacionproveedor::where('IDCotizacion', $request->input('IDCotizacion'))->where('IDProveedor', $request->input('IDProveedor'))->first();

            if ($cotproveedor) {
                $cotproveedor->IDAreaColab = $areacolab->ID;
                $cotproveedor->IDCotizacion = $request->input('IDCotizacion');
                $cotproveedor->IDProveedor = $request->input('IDProveedor');
                $cotproveedor->FechaReg = Carbon::now('America/Guayaquil');
                $cotproveedor->Archivo = $request->input('Nombre');
                $cotproveedor->save();
            } else {
                $cotproveedor = new Cotizacionproveedor();
                $cotproveedor->IDAreaColab = $areacolab->ID;
                $cotproveedor->IDCotizacion = $request->input('IDCotizacion');
                $cotproveedor->IDProveedor = $request->input('IDProveedor');
                $cotproveedor->FechaReg = Carbon::now('America/Guayaquil');
                $cotproveedor->Archivo = $request->input('Nombre');
                $cotproveedor->save();
            }

            Excel::load($request->file('file'), function ($reader) use ($detallescot, &$errors, $request) {
                $excel = $reader->get();
                for ($i = 0; $i < count($detallescot); $i++) {
                    try {
                        DB::beginTransaction();
                        if ($excel[$i]->cantidad && $excel[$i]->precio) {
                            $detalle = new Detallecotizacionproveedor();
                            $detalle = Detallecotizacionproveedor::where('IDDetallecotizacion', $detallescot[$i]->ID)->where('IDProveedor', $request->input('IDProveedor'))->where('Referencia', $excel[$i]->ref)->first();
                            $detalle->Cantidad = $excel[$i]->cantidad;
                            $detalle->Precio = $excel[$i]->precio;
                            $detalle->Etiqueta = $excel[$i]->descripcion;
                            $detalle->Estado = 'BRR';
                            $detalle->save();
                            DB::commit();
                        } else {
                            $errors = 'Formato de Excel Incorrecto';
                            throw new Exception('Datos Incorrectos');

                        }

                    } catch (\Exception $e) {
                        DB::rollBack();
                        //return response()->json($e, 401);
                        break;
                    }
                }
            });
            if ($errors != "") {
                return response()->json($errors, 401);
            }
            return response()->json(true, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function pdfOCompra($idocompra)
    {
        set_time_limit(300);
        $detalles = Detalleordencompra::where('IDOrdencompra',$idocompra)->get();
        $pdf = PDF::loadView('ordencompra',array('detalles' => $detalles ));
       
        return $pdf->stream('ordencompra.pdf');
       /*  $detalles = Detalleordencompra::where('IDOrdencompra',$idocompra);
        return View::make('home.home')
            ->with('questions', $questions); */
    
        //return view('ordencompra',array('detalles' => $detalles ));
    }

}
