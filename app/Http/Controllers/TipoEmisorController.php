<?php

namespace App\Http\Controllers;

use App\Models\Tipoemisor;
use Illuminate\Http\Request;

class TipoEmisorController extends Controller
{
    public function combo()
    {
        try {
            $tipoemisor = Tipoemisor::where('Estado', 'ACT')->get([ 'ID', 'Descripcion' ]);
            return response()->json($tipoemisor, 200);
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
                $tipoemisor = Tipoemisor::paginate($request->input('psize'));
                return response()->json($tipoemisor, 200);
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
                $tipoemisor = Tipoemisor::create($request->all());
                $tipoemisor->Estado = $tipoemisor->Estado ? 'ACT' : 'INA';
                $tipoemisor->save();
                return response()->json($tipoemisor, 201);
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
            $tipoemisor = Tipoemisor::find($id);
            return response()->json($tipoemisor, 200);
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
                $tipoemisor = Tipoemisor::find($id);
                $tipoemisor->fill($request->all());
                $tipoemisor->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $tipoemisor->save();
                return response()->json($tipoemisor, 200);
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
            $tipoemisor = Tipoemisor::find($id);
            $tipoemisor->Estado = 'INA';
            $tipoemisor->save();
            return Response($tipoemisor, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
