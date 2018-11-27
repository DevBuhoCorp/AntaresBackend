<?php

namespace App\Http\Controllers;


use App\Models\Bodega;
use App\Models\BodegaTMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            $Bodega = Bodega::
                            join('Ciudad', 'Ciudad.ID', 'IDCiudad')
                            ->join('Pais', 'Pais.ID', 'Ciudad.IDPais')
                            ->select([ 'Bodega.*', DB::raw("concat(Ciudad.Descripcion, ' - ', Pais.Descripcion) as Ciudad") ])
                            ->paginate($request->input('psize'));
            return response()->json($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo()
    {
        try {
            $Bodega = Bodega::where('Estado', 'ACT')->get();
            return response()->json($Bodega, 200);
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
    public function store(Request $request)
    {
        try {
            $data = $request->all();
//            $data["Estado"] = $data["Estado"] ? 'ACT' : 'INA';
            $Bodega = Bodega::create($data);
            return response()->json($Bodega, 201);
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
        try {
            $Bodega = Bodega::find($id);
            return response()->json($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
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
        try {
            $Bodega = Bodega::find($id);
            $Bodega->fill($request->all());
//            $Bodega->Estado = $request->input('Estado') ? 'ACT' : 'INA';
            $Bodega->save();
            return response()->json($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Bodega = Bodega::find($id);
            $Bodega->Estado = 'INA';
            $Bodega->save();
            return Response($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store_bodegaTipoMovimiento()
    {
        try {
            $Bodega = BodegaTMovimiento::all();
            return Response($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
