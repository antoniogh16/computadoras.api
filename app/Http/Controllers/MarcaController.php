<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Departamento;
use DB;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::select('marcas.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','marcas.departamento_id')
        ->paginate(10);
        return response()->json($marcas);
    }
    public function store(Request $request)
    {
        $rules = [
            'marca' => 'required|string|min:1|max:100',
            'departamento_id' => 'required|numeric'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $marca = new Marca($request->input());
        $marca->save();
        return response()->json([
            'status' => true,
            'message' => 'marca creada exitosamente'
        ],200);
    }
    public function show(Marca $marca)
    {
        return response()->json(['status' => true, 'data' => $marca]);
    }
    public function update(Request $request, Marca $marca)
    {
        $rules = [
            'marca' => 'required|string|min:1|max:100',
            'departamento_id' => 'required|numeric'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $marca = update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'marca actualizada exitosamente'
        ],200);
    }
    public function destroy(Marca $marca)
    {
        $marca->delete();
        return response()->json([
            'status' => true,
            'message' => 'marca eliminada exitosamente'
        ],200);
    }
    public function MarcasByDepartamento(){
        $marcas = Marca::select(DB::raw('count(marcas.id) as count,
        departamentos.name'))->rightJoin('departamentos','departamentos.id','=','marcas.departamento_id')
        ->groupBy('departamentos.name')->get();
        return response()->json($marcas);
    }
    public function all(){
        $marcas = Marca::select('marcas.*','departamentos.name as departamento')
        ->join('departamentos','departamentos.id','=','marcas.departamento_id')->get();
        return response()->json($marcas); 
    }
}
