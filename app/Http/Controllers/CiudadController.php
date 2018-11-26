<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $Ciudad = Ciudad::join('Pais', 'Pais.ID', 'IDPais')
                            ->select([ 'Ciudad.*', 'Pais.Descripcion as Pais' ])
                            ->paginate($request->input('psize'));
            return response()->json($Ciudad, 200);
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
            $Bodega = Ciudad::join('Pais', 'Pais.ID', 'IDPais')
                        ->where('Ciudad.Estado', 'ACT')
                        ->get([ 'Ciudad.ID' , DB::raw("concat(Ciudad.Descripcion, ' - ', Pais.Descripcion) as Descripcion") ]);
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
            $data["Estado"] = $data["Estado"] ? 'ACT' : 'INA';
            $Ciudad = Ciudad::create($data);
            return response()->json($Ciudad, 201);
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
            $Ciudad = Ciudad::find($id);
            return response()->json($Ciudad, 200);
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

            $data = $request->all();
            $data["Estado"] = $data["Estado"] ? 'ACT' : 'INA';

            $Ciudad = Ciudad::find($id);
            $Ciudad->fill($data);
            $Ciudad->save();
            return response()->json($Ciudad, 200);
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
            $Ciudad = Ciudad::find($id);
            $Ciudad->Estado = 'INA';
            $Ciudad->save();
            return Response($Ciudad, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
