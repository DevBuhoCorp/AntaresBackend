<?php

namespace App\Http\Controllers;

use App\Models\Tipomovimiento;
use Illuminate\Http\Request;

class TipoMovimientoController extends Controller
{

    public function combo()
    {
        try {
            $Tipomovimiento = Tipomovimiento::where('Estado', 'ACT')->get(['ID', 'Descripcion', 'Tipo']);
            return response()->json($Tipomovimiento, 200);
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
            $Tipomovimiento = Tipomovimiento::paginate($request->input('psize'));
            return response()->json($Tipomovimiento, 200);
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
                $Tipomovimiento = Tipomovimiento::create($request->all());
                $Tipomovimiento->Estado = $Tipomovimiento->Estado ? 'ACT' : 'INA';
                $Tipomovimiento->save();
                return response()->json($Tipomovimiento, 201);
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
            $Tipomovimiento = Tipomovimiento::find($id);
            return response()->json($Tipomovimiento, 200);
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
                $Tipomovimiento = Tipomovimiento::find($id);
                $Tipomovimiento->fill($request->all());
                $Tipomovimiento->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $Tipomovimiento->save();
                return response()->json($Tipomovimiento, 200);
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
            $Tipomovimiento = Tipomovimiento::find($id);
            $Tipomovimiento->Estado = 'INA';
            $Tipomovimiento->save();
            return Response($Tipomovimiento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
