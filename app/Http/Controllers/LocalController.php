<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Departamento;
use DB;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        $locals = Local::select('locals.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','locals.departamento_id')
        ->paginate(10);
        return response()->json($locals);
    }
    public function store(Request $request)
    {
        $rules = [
            'direccion' => 'required|string|min:1|max:200',
            'exterior' => 'required|max:10',
            'departamento_id' => 'required|numeric'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $local = new Local($request->input());
        $local->save();
        return response()->json([
            'status' => true,
            'message' => 'local creado exitosamente'
        ],200);
    }
    public function show(Local $local)
    {
        return response()->json(['status' => true, 'data' => $local]);
    }
    public function update(Request $request, Local $local)
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
        $local = update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'local creado exitosamente'
        ],200);
    }
    public function destroy(Local $local)
    {
        $local->delete();
        return response()->json([
            'status' => true,
            'message' => 'local eliminado exitosamente'
        ],200);
    }
    public function LocalsByDepartamento(){
        $locals = Local::select(DB::raw('count(locals.id) as count,
        departamentos.name'))->rightJoin('departamentos','departamentos.id','=','locals.departamento_id')
        ->groupBy('departamentos.name')->get();
        return response()->json($locals);
    }
    public function all(){
        $locals = Local::select('locals.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','locals.departamento_id')->get();
        return response()->json($locals); 
    }
}
