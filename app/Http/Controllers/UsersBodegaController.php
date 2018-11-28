<?php

namespace App\Http\Controllers;

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
