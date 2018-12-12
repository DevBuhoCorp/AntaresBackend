<?php

namespace App\Http\Controllers;

use App\Models\Detalleop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public static function exportCotizacion($cotizacion)
    {
        try {
            if (true) {

                $opedidos = Detalleop::join('detallecotizacion as dc', 'dc.IDDetalleOrdenPedido', 'detalleop.ID')
                    ->join('cotizacion as c', 'dc.IDCotizacion', 'c.ID')
                    ->where('c.ID', $cotizacion)
                    ->select('detalleop.*')->get();

                return Excel::load('app/Files/Cotizacion.xlsx', function ($reader) use ($opedidos) {

                    $sheet = $reader->getActiveSheet();
                    $row = 12;

                    foreach ($opedidos as $opedido) {

                        $sheet->setCellValue('A' . $row, $opedido->Etiqueta);
                        $sheet->setCellValue('B' . $row, $opedido->PrecioRef);
                        $sheet->setCellValue('C' . $row, $opedido->Cantidad);
                        $sheet->setCellValue('D' . $row, $opedido->Saldo);
                        $row++;

                    }

                })->store('xlsx');

            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public static function importCotizacion(Request $request)
    {
        try {
            if (true) {

                /* $opedidos = Detalleop::join('detallecotizacion as dc', 'dc.IDDetalleOrdenPedido', 'detalleop.ID')
                ->join('cotizacion as c', 'dc.IDCotizacion', 'c.ID')
                ->where('c.ID', $cotizacion)
                ->select('detalleop.*')->get(); */

               

                return Excel::load($request->all()[0], function ($reader) {

                    $sheet = $reader->getActiveSheet();
                    $row = 12;

                    /* foreach ($opedidos as $opedido) {

                    $sheet->setCellValue('A' . $row, $opedido->Etiqueta);
                    $sheet->setCellValue('B' . $row, $opedido->PrecioRef);
                    $sheet->setCellValue('C' . $row, $opedido->Cantidad);
                    $sheet->setCellValue('D' . $row, $opedido->Saldo);
                    $row++;

                    } */

                    /*  foreach ($reader->toArray() as $row) {
                User::firstOrCreate($row);
                } */

                })->store('invoices.xlsx');

            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
