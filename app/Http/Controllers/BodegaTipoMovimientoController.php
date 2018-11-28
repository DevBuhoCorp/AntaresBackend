<?php

namespace App\Http\Controllers;

use App\Models\BodegaTMovimiento;
use Illuminate\Http\Request;

class BodegaTipoMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $bodega)
    {
        try {
            $BodegaTipoMovimiento = BodegaTMovimiento::where('IDBodega', $bodega)->get(['IDTipoMovimiento as ID']);
//            $BodegaTipoMovimiento = BodegaTMovimiento::join('TipoMovimiento', 'TipoMovimiento.ID', 'IDTipoMovimiento')->where( 'IDBodega', $bodega)->get([ 'TipoMovimiento.*' ]);
            return response()->json($BodegaTipoMovimiento, 200);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bodega)
    {
        try {
            BodegaTMovimiento::where('IDBodega', $bodega)->delete();
            foreach ($request->all() as $row) {
                BodegaTMovimiento::create(["IDTipoMovimiento" => $row, 'IDBodega' => $bodega]);
            }

            return response()->json(true, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
