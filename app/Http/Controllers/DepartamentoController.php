<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{

    public function combo()
    {
        try {
            $departamento = Departamento::where('Estado', 'ACT')->get([ 'ID', 'Descripcion' ]);
            return response()->json($departamento, 200);
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
                $departamento = Departamento::paginate($request->input('psize'));
                return response()->json($departamento, 200);
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
                $departamento = Departamento::create($request->all());
                $departamento->Estado = $departamento->Estado ? 'ACT' : 'INA';
                $departamento->save();
                return response()->json($departamento, 201);
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
            $departamento = Departamento::find($id);
            return response()->json($departamento, 200);
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
                $departamento = Departamento::find($id);
                $departamento->fill($request->all());
                $departamento->Estado = $request->input('Estado') ? 'ACT' : 'INA';                
                $departamento->save();
                return response()->json($departamento, 200);
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
            $departamento = Departamento::find($id);
            $departamento->Estado = 'INA';
            $departamento->save();
            return Response($departamento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
