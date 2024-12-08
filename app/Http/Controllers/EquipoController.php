<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::select('equipos.*', 'departamentos.name as departamento')
            ->join('departamentos', 'departamentos.id', '=', 'equipos.departamento_id')
            ->paginate(10);

        return response()->json($equipos);
    }

    public function store(Request $request)
    {
        $rules = [
            'ram' => 'required|string|min:1|max:100',
            'procesador' => 'required|string|min:1|max:100',
            'graficos' => 'required|string|min:1|max:100',
            'monitor' => 'required|string|min:1|max:100',
            'hd' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:200',
            'imagen' => 'image|nullable|max:1999',
            'departamento_id' => 'required|numeric|exists:departamentos,id'
        ];

        $validated = $request->validate($rules);

        $equipo = new Equipo($validated);

        if ($request->hasFile('imagen')) {
            $fileNameToStore = $request->file('imagen')->store('imagenes', 'public');
            $equipo->imagen = $fileNameToStore;
        }

        $equipo->save();

        return response()->json([
            'status' => true,
            'message' => 'Equipo creado exitosamente'
        ], 201);
    }

    public function show(Equipo $equipo)
    {
        return response()->json(['status' => true, 'data' => $equipo]);
    }

    public function update(Request $request, Equipo $equipo)
    {
        $rules = [
            'ram' => 'required|string|min:1|max:100',
            'procesador' => 'required|string|min:1|max:100',
            'graficos' => 'required|string|min:1|max:100',
            'monitor' => 'required|string|min:1|max:100',
            'hd' => 'required|string|min:1|max:100',
            'descripcion' => 'required|string|min:1|max:200',
            'imagen' => 'image|nullable|max:1999',
            'departamento_id' => 'required|numeric|exists:departamentos,id'
        ];

        $validated = $request->validate($rules);

        $equipo->fill($validated);

        if ($request->hasFile('imagen')) {
            if ($equipo->imagen) {
                Storage::disk('public')->delete($equipo->imagen);
            }
            $equipo->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $equipo->save();

        return response()->json([
            'status' => true,
            'message' => 'Equipo actualizado exitosamente'
        ], 200);
    }

    public function destroy(Equipo $equipo)
    {
        try {
            if ($equipo->imagen) {
                Storage::disk('public')->delete($equipo->imagen);
            }

            $equipo->delete();

            return response()->json([
                'status' => true,
                'message' => 'Equipo eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar el equipo'
            ], 500);
        }
    }

    public function EquiposByDepartamento(){
        $equipos = Equipo::select(DB::raw('count(equipos.id) as count,
        departamentos.name'))->rightJoin('departamentos','departamentos.id','=','equipos.departamento_id')
        ->groupBy('departamentos.name')->get();
        return response()->json($equipos);
    }

    public function all()
    {
        $equipos = Equipo::select('equipos.*', 'departamentos.name as departamento')
            ->join('departamentos', 'departamentos.id', '=', 'equipos.departamento_id')
            ->get();

        return response()->json($equipos);
    }
}

