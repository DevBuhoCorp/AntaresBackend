<?php

namespace App\Http\Controllers;

use App\Models\TipoMovimientoReverso;
use Illuminate\Http\Request;

class TipoMovimientoReversoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        try {
            $TipoMovimientoReverso = TipoMovimientoReverso::where('IDTipoMovimiento', $id)->get(['IDTipoMovimientoReverso as ID']);
            return response()->json($TipoMovimientoReverso, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $movimiento)
    {
        try {
            TipoMovimientoReverso::where('IDTipoMovimiento', $movimiento)->delete();
            foreach ($request->all() as $row) {
                TipoMovimientoReverso::create(["IDTipoMovimientoReverso" => $row, 'IDTipoMovimiento' => $movimiento]);
            }

            return response()->json(true, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
