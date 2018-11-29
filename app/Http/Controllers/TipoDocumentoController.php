<?php

namespace App\Http\Controllers;

use App\Models\Tipodocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function combo()
    {
        try {
            $Tipodocumento = Tipodocumento::where('Estado', 'ACT')->get(['ID', 'Descripcion']);
            return response()->json($Tipodocumento, 200);
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
            $Tipodocumento = Tipodocumento::paginate($request->input('psize'));
            return response()->json($Tipodocumento, 200);
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
            if ($request->isJson()) {
                $data = $request->all();
                $data["Estado"] = $data["Estado"] ? 'ACT' : 'INA';
                $Tipodocumento = Tipodocumento::create( $data );
                $Tipodocumento->save();
                return response()->json($Tipodocumento, 201);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
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
            $Tipodocumento = Tipodocumento::find($id);
            return response()->json($Tipodocumento, 200);
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
            if ($request->isJson()) {
                $data = $request->all();
                $data["Estado"] = $data["Estado"] ? 'ACT' : 'INA';
                $Tipodocumento = Tipodocumento::find($id);
                $Tipodocumento->fill( $data );
                $Tipodocumento->save();
                return response()->json($Tipodocumento, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
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
            $Tipodocumento = Tipodocumento::find($id);
            $Tipodocumento->Estado = 'INA';
            $Tipodocumento->save();
            return Response($Tipodocumento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
