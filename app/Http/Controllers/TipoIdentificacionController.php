<?php

namespace App\Http\Controllers;

use App\Models\Tipoidentificacion;
use Illuminate\Http\Request;

class TipoIdentificacionController extends Controller
{
    public function combo()
    {
        try {
            $Tipoidentificacion = Tipoidentificacion::where('Estado', 'ACT')->get([ 'ID', 'Descripcion' ]);
            return response()->json($Tipoidentificacion, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->isJson()) {
                $Tipoidentificacion = Tipoidentificacion::paginate($request->input('psize'));
                return response()->json($Tipoidentificacion, 200);
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
                $Tipoidentificacion = Tipoidentificacion::create($request->all());
                $Tipoidentificacion->Estado = $Tipoidentificacion->Estado ? 'ACT' : 'INA';
                $Tipoidentificacion->save();
                return response()->json($Tipoidentificacion, 201);
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
    public function show($id)
    {
        try {
            $Tipoidentificacion = Tipoidentificacion::find($id);
            return response()->json($Tipoidentificacion, 200);
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
        try {
            if ($request->isJson()) {
                $Tipoidentificacion = Tipoidentificacion::find($id);
                $Tipoidentificacion->fill($request->all());
                $Tipoidentificacion->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $Tipoidentificacion->save();
                return response()->json($Tipoidentificacion, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Tipoidentificacion = Tipoidentificacion::find($id);
            $Tipoidentificacion->Estado = 'INA';
            $Tipoidentificacion->save();
            return Response($Tipoidentificacion, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
