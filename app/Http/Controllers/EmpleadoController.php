<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Departamento;
use DB;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::select('empleados.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','empleados.departamento_id')
        ->paginate(10);
        return response()->json($empleados);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'telefono' => 'required|max:15',
            'departamento_id' => 'required|numeric'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $empleado = new Empleado($request->input());
        $empleado->save();
        return response()->json([
            'status' => true,
            'message' => 'empleado creado exitosamente'
        ],200);
    }
    public function show(Empleado $empleado)
    {
        return response()->json(['status' => true, 'data' => $empleado]);
    }
    public function update(Request $request, Empleado $empleado)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'telefono' => 'required|max:15',
            'departamento_id' => 'required|numeric'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $empleado = update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'empleado actualizado exitosamente'
        ],200);
    }
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return response()->json([
            'status' => true,
            'message' => 'empleado eliminado exitosamente'
        ],200);
    }
    public function EmpleadosByDepartamento(){
        $empleados = Empleado::select(DB::raw('count(empleados.id) as count,
        departamentos.name'))->rightJoin('departamentos','departamentos.id','=','empleados.departamento_id')
        ->groupBy('departamentos.name')->get();
        return response()->json($empleados);
    }
    public function all(){
        $empleados = Empleado::select('empleados.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','empleados.departamento_id')->get();
        return response()->json($empleados); 
    }
}
