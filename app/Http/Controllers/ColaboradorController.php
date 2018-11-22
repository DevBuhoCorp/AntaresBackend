<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use Illuminate\Support\Facades\DB;
use App\Models\Areacolab;
use Carbon\Carbon;
use PHPUnit\Runner\Exception;

class ColaboradorController extends Controller
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
                $colaborador = Colaborador::join('areacolab as ac', 'ac.IdColaborador', '=', 'colaborador.ID')
                    ->join('cargo as cg', 'ac.IdCargo', '=', 'cg.ID')
                    ->join('area as a', 'ac.IdArea', '=', 'a.ID')
                    ->join('departamento as d', 'a.IDDepartamento', '=', 'd.ID')
                    ->select(DB::raw("CONCAT(colaborador.NombrePrimero,' ',colaborador.ApellidoPaterno) as Nombre"), 'colaborador.Cedula', 'ac.FechaInicio', 'a.Descripcion as Area', 'd.Descripcion as Departamento', 'cg.Descripcion as Cargo', 'colaborador.Estado', 'colaborador.ID')
                    ->paginate($request->input('psize'));
                return response()->json($colaborador, 200);
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

                $colaborador = Colaborador::create($request->all());
                $colaborador->Estado = $colaborador->Estado ? 'ACT' : 'INA';
                $colaborador->save();

                if ($request->input('IdArea') && $request->input('IdCargo')) {
                    $areacolab = new Areacolab();
                    $carbon = new Carbon($request->input('FechaInicio'));
                    $fecha = $carbon->toDateString();
                    $areacolab->FechaInicio = $fecha;
                    $areacolab->IdColaborador = $colaborador->ID;
                    $areacolab->IdArea = $request->input('IdArea');
                    $areacolab->IdCargo = $request->input('IdCargo');
                    $areacolab->Estado = 'ACT';
                    $areacolab->save();
                }

                return response()->json(true, 201);
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

            $colaborador = Colaborador::join('areacolab as ac', 'ac.IdColaborador', '=', 'colaborador.ID')
                ->join('cargo as cg', 'ac.IdCargo', '=', 'cg.ID')
                ->join('area as a', 'ac.IdArea', '=', 'a.ID')
                ->join('departamento as d', 'a.IDDepartamento', '=', 'd.ID')
                ->where('colaborador.ID', $id)
                ->get(['colaborador.NombrePrimero', 'colaborador.NombreSegundo', 'colaborador.ApellidoPaterno', 'colaborador.ApellidoMaterno', 'colaborador.Cedula', 'ac.IdCargo', 'ac.IdArea', 'ac.FechaInicio', 'colaborador.Estado', 'd.ID as IDDepartamento', 'colaborador.ID'])[0];
            return response()->json($colaborador, 200);

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
                $colaborador = Colaborador::find($id);
                $colaborador->fill($request->all());
                $colaborador->Estado = $request->input('Estado') ? 'ACT' : 'INA';
                $colaborador->save();
                return response()->json($colaborador, 200);
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
            $colaborador = Colaborador::find($id);
            $colaborador->Estado = 'INA';
            $colaborador->save();
            return Response($colaborador, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function colaboradorarea(Request $request)
    {
        try {
            if ($request->isJson()) {
                $colaborador = Colaborador::where('Estado', 'ACT')
                    ->select('colaborador.ID', DB::raw("CONCAT(colaborador.NombrePrimero,' ',colaborador.ApellidoPaterno) as Nombre"), 'colaborador.Cedula', 'colaborador.Estado')
                    ->paginate($request->input('psize'));
                return response()->json($colaborador, 200);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function colaboradorareashow($id)
    {
        try {
            $colaborador = Colaborador::join('areacolab as ac', 'ac.IdColaborador', '=', 'colaborador.ID')
                ->join('cargo as cg', 'ac.IdCargo', '=', 'cg.ID')
                ->join('area as a', 'ac.IdArea', '=', 'a.ID')
                ->join('departamento as d', 'a.IDDepartamento', '=', 'd.ID')
                ->where('colaborador.ID', $id)
                ->whereNull('ac.FechaFin')
                ->get(['ac.IdCargo', 'ac.IdArea', 'ac.FechaInicio', 'ac.Estado', 'd.ID as IDDepartamento', 'colaborador.ID']);
            if (count($colaborador)) {
                return response()->json($colaborador, 200);
            } else {
                $colaborador = Colaborador::where('colaborador.ID', $id)
                    ->get();
                return response()->json($colaborador, 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function colaboradorareaupd(Request $request, $id)
    {
        try {
            if ($request->isJson()) {
                $areacolab = Areacolab::where('IdColaborador', $id)
                    ->whereNull('FechaFin')
                    ->first();
                if ($areacolab) {
                    $carbon = new Carbon($request->input('FechaInicio'));
                    $fecha = $carbon->toDateString();

                    $areacolab->FechaFin = $carbon->subDay()->toDateString();
                    $areacolab->Estado = 'INA';
                    $areacolab->save();

                    $areacolab = new Areacolab();
                    $areacolab->FechaInicio = $fecha;
                    $areacolab->IdColaborador = $id;
                    $areacolab->IdArea = $request->input('IdArea');
                    $areacolab->IdCargo = $request->input('IdCargo');
                    $areacolab->Estado = $request->input('Estado') ? 'ACT' : 'INA';;
                    $areacolab->save();
                    return response()->json($areacolab, 201);
                } else {
                    $areacolab = new Areacolab();
                    $carbon = new Carbon($request->input('FechaInicio'));
                    $fecha = $carbon->toDateString();
                    $areacolab->FechaInicio = $fecha;
                    $areacolab->IdColaborador = $id;
                    $areacolab->IdArea = $request->input('IdArea');
                    $areacolab->IdCargo = $request->input('IdCargo');
                    $areacolab->Estado = $request->input('Estado') ? 'ACT' : 'INA';;
                    $areacolab->save();
                    return response()->json($areacolab, 201);
                }

            }
            return response()->json(['error' => 'Unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
