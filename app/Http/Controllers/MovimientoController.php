<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bodega_producto(Request $request, $bodega)
    {
        try {
            $Producto = Producto::
                join('Stock', 'Stock.IDProducto', 'Producto.ID')
                ->join('Bodega', 'Bodega.ID', 'Stock.IDBodega')
                ->where('Bodega.ID', $bodega)
                ->whereRaw('(Stock.Cantidad - Stock.CantComprometida) > 0')
                ->get([ 'Producto.ID', 'Producto.Nombre', 'Stock.Cantidad as Stock']);
            return response()->json($Producto, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
