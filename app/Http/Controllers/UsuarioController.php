<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\Datospersonale;
use App\Models\Empresa;
use App\Models\Usersempresa;
use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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
                $user = Colaborador::join('Users', 'Users.id', '=', 'IDUser')
                    ->join('Rol', 'Rol.id', '=', 'Users.IDRol')
                    ->select('DatosPersonales.*', 'Users.email', 'Users.name', 'Users.IDRol', 'Rol.Descripcion as Rol');
                $user = $user->paginate($request->input('psize'));
                return response()->json($user, 200);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->isJson()) {

                $usuario = new User();
                $usuario->name = $request->input("name");
                $usuario->email = $request->input("email");
                $usuario->password = password_hash($request->input("Cedula"), PASSWORD_BCRYPT);
                $usuario->save();
//                $usuario->IDRol = $request->input("IDRol");
                $Colaborador = new Colaborador();
                $Colaborador->fill( $request->all() );
                $Colaborador->IDUser = $usuario->id;
                $Colaborador->Estado = $request->input("Estado") ? 'ACT' : 'INA';
                $Colaborador->save();
                return response()->json($Colaborador, 201);
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
        $user = Colaborador::join('Users', 'Users.id', '=', 'IDUser')
            ->join('Rol', 'Rol.id', '=', 'Users.IDRol')
            ->where('Colaborador.IDUser', '=', $id)
            ->select('Colaborador.*', 'Users.email', 'Users.name', 'Users.IDRol', 'Rol.Descripcion as Rol')->get();
        return response()->json($user, 200);
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
    public function update(Request $request, $userid, $datosid)
    {
        $usuario = User::find($userid);
        $usuario->fill( $request->all() );
        $usuario->save();
//        $usuario->name = $request->input("name");
//        $usuario->email = $request->input("email");
//        $usuario->IDRol = $request->input("IDRol");


        $Colaborador = Colaborador::find($datosid);
        $Colaborador->fill( $request->all() );
        $Colaborador->IDUser = $usuario->id;
        $Colaborador->Estado = $request->input("Estado") ? 'ACT' : 'INA';
        $Colaborador->save();
//        $Colaborador->FotoPerfil = $request->input("FotoPerfil");

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
            $Colaborador = Colaborador::find($id);
            $Colaborador->Estado = 'INA';
            $Colaborador->save();
            return Response($Colaborador, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function changepass(Request $request, $userid)
    {
        $usuario = User::find($userid);
        if (password_verify($request->input('OldPass'),$usuario->password)) {
            $usuario->password = password_hash($request->input('NewPass'), PASSWORD_BCRYPT);
            $usuario->save();
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }
}
