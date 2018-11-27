<?php

namespace App\Http\Controllers;

use App\Models\UsersTMovimiento;
use Illuminate\Http\Request;

class UsersTipoMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user)
    {
        try {
            $UsersTipoMovimiento = UsersTMovimiento::where('IDUsers', $user)->get(['IDTipoMovimiento as ID']);
            return response()->json($UsersTipoMovimiento, 200);
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
            UsersTMovimiento::where('IDUsers', $user)->delete();
            foreach ($request->all() as $row) {
                UsersTMovimiento::create(["IDTipoMovimiento" => $row, 'IDUsers' => $user]);
            }

            return response()->json(true, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
