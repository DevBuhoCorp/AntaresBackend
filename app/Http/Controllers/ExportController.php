<?php

namespace App\Http\Controllers;

use App\Models\Detallecotizacion;
use App\Models\Detallecotizacionproveedor;
use App\Models\Detalleop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Exception;

class ExportController extends Controller
{

    public static function exportCotizacion($cotizacion)
    {
        try {
            if (true) {

                $opedidos = Detalleop::join('detallecotizacion as dc', 'dc.IDDetalleOrdenPedido', 'detalleop.ID')
                    ->join('cotizacion as c', 'dc.IDCotizacion', 'c.ID')
                    ->join('areacolab as ac', 'c.IDAreaColab', 'ac.ID')
                    ->join('colaborador as cl', 'ac.IdColaborador', 'cl.ID')
                    ->where('c.ID', $cotizacion)
                    ->select('detalleop.*', 'c.FechaIni', 'c.FechaFin', DB::raw("concat(cl.NombrePrimero, ' ', cl.NombreSegundo, ' ', cl.ApellidoPaterno, ' ', cl.ApellidoMaterno) as Colaborador"))->get();

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
                        
                        $sheet->setCellValue('A' . $row, $opedido->Etiqueta);
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
            Excel::load($request->file('file')->getRealPath(), function ($reader) use ($detallescot, &$errors, $request) {
                $excel = $reader->get();

                for ($i = 0; $i < count($detallescot); $i++) {
                    try {
                        DB::beginTransaction();

                        if ($excel[$i]->cantidad && $excel[$i]->precio) {
                            $detalle = new Detallecotizacionproveedor();
                            $detalle = Detallecotizacionproveedor::where('IDDetallecotizacion', $detallescot[$i]->ID)->where('IDProveedor', $request->input('IDProveedor'))->first();
                            $detalle->Cantidad = $excel[$i]->cantidad;
                            $detalle->Precio = $excel[$i]->precio;
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
}
