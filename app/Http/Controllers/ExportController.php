<?php

namespace App\Http\Controllers;

use App\Models\Ordenpedido;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Detalleop;

class ExportController extends Controller
{

    public static function exportCotizacion($cotizacion)
    {
        try {
            if (true) {

                /*  $query = (new TransaccionController())->query($request);
                $transacciones = $query->with('detalletransaccions_v2')->get(['ID', 'Fecha', 'Etiqueta', 'Debe', 'Haber']);
                $totales = ["Debe" => $query->sum('Transaccion.Debe'), "Haber" => $query->sum('Transaccion.Haber')]; */

                $opedidos = Detalleop::join('detallecotizacion as dc', 'dc.IDDetalleOrdenPedido', 'detalleop.ID')
                    ->join('cotizacion as c', 'dc.IDCotizacion', 'c.ID')
                    ->where('c.ID', $cotizacion)
                    ->select('detalleop.*')->get();

                return Excel::load('app/Files/Cotizacion.xlsx', function ($reader) use ($opedidos) {

                    $sheet = $reader->getActiveSheet();

                    /* $sheet->setCellValue('C9', $totales["Debe"]);
                    $sheet->setCellValue('F9', $totales["Haber"]); */

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
}
