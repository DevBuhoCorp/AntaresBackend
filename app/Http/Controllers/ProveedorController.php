<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->isJson()) {
                $Proveedor = Proveedor::
                        join('TipoEmisor', 'IdTipoEmisor', 'TipoEmisor.ID')
                        ->join('Contribuyente', 'IdContribuyente', 'Contribuyente.ID')
                        ->join('TipoIdentificacion', 'IdTipoIdentificacion', 'TipoIdentificacion.ID')
                        ->select([ 'Proveedor.*', 'Contribuyente.Descripcion as Contribuyente', 'TipoIdentificacion.Descripcion as TIdentificacion', 'TipoEmisor.Descripcion as TEmisor' ])
                        ->paginate($request->input('psize'));
                return response()->json($Proveedor, 200);
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
                $Proveedor = Proveedor::create($request->all());
                $Proveedor->Estado = $Proveedor->Estado ? 'ACT' : 'INA';
                $Proveedor->save();
                return response()->json($Proveedor, 201);
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
            $Proveedor = Proveedor::find($id);
            return response()->json($Proveedor, 200);
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
                $Proveedor = Proveedor::find($id);
                $Proveedor->fill($request->all());
                $Proveedor->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $Proveedor->save();
                return response()->json($Proveedor, 200);
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
            $Proveedor = Proveedor::find($id);
            $Proveedor->Estado = 'INA';
            $Proveedor->save();
            return Response($Proveedor, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
