<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos);
    }
    public function store(Request $request)
    {
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $departamento = new Departamento($request->input());
        $departamento->save();
        return response()->json([
            'status' => true,
            'message' => 'Departamento creado exitosamente'
        ],200);
    }
    public function show(Departamento $departamento)
    {
        return response()->json(['status' => true, 'data' => $departamento]);
    }
    public function update(Request $request, Departamento $departamento)
{
    $rules = ['name' => 'required|string|min:1|max:100'];
    $validator = \Validator::make($request->input(), $rules);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->all()
        ], 400);
    }

    $departamento->update($request->only('name'));

    return response()->json([
        'status' => true,
        'message' => 'Departamento actualizado exitosamente'
    ], 200);
}

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return response()->json([
            'status' => true,
            'message' => 'Departamento eliminado exitosamente'
        ],200);
    }
}
