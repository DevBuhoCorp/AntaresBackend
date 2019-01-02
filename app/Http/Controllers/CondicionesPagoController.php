<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condicionespago;

class CondicionesPagoController extends Controller
{

    public function combo()
    {
        try {
            $Condiciones = Condicionespago::where('Estado', 'ACT')->get(['ID', 'Etiqueta']);
            return response()->json($Condiciones, 200);
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
                $Condiciones = Condicionespago::paginate($request->input('psize'));

                return response()->json($Condiciones, 200);
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
                $Condiciones = Condicionespago::create($request->all());
                $Condiciones->Estado = $Condiciones->Estado ? 'ACT' : 'INA';
                $Condiciones->save();
                return response()->json($Condiciones, 201);
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
            $Condiciones = Condicionespago::find($id);
            return response()->json($Condiciones, 200);
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
                $Condiciones = Condicionespago::find($id);
                $Condiciones->fill($request->all());
                $Condiciones->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $Condiciones->save();
                return response()->json($Condiciones, 200);
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
            $Condiciones = Condicionespago::find($id);
            $Condiciones->Estado = 'INA';
            $Condiciones->save();
            return Response($Condiciones, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
