<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Tipomovimiento;
use App\Models\UsersBodega;
use Illuminate\Http\Request;

class UsersBodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user)
    {
        try {
            $UsersBodega = UsersBodega::where('IDUsers', $user)->get(['IDBodega as ID']);
            return response()->json($UsersBodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        try {
            $Bodega = Bodega::join('BodegaUsuario', 'BodegaUsuario.IDBodega', 'Bodega.ID' )
                            ->where('BodegaUsuario.IDUsers', $request->user()->id)
                            ->get([ 'Bodega.ID', 'Bodega.Descripcion']);
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
    public function user_bodega_movimiento(Request $request)
    {
        try {
            $Bodega = Tipomovimiento::
                join('bodegatmovimiento', 'bodegatmovimiento.IDTipoMovimiento', 'Tipomovimiento.ID')
                ->join('usuariotmovimiento', 'usuariotmovimiento.IDTipoMovimiento', 'Tipomovimiento.ID')
                ->join('users', 'users.id', 'usuariotmovimiento.IDUsers')
                ->join('Bodega', 'Bodega.ID', 'bodegatmovimiento.IDBodega')
                ->where('users.id', $request->user()->id)
                ->where('Bodega.ID', $request->input('Bodega'))
                ->where('Tipomovimiento.Tipo', $request->input('Tipo'))
                ->get([ 'Tipomovimiento.ID', 'Tipomovimiento.Descripcion']);
            return response()->json($Bodega, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user)
    {
        try {
            UsersBodega::where('IDUsers', $user)->delete();
            foreach ($request->all() as $row) {
                UsersBodega::create(["IDBodega" => $row, 'IDUsers' => $user]);
            }

            return response()->json(true, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
