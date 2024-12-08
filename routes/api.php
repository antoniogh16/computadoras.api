<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('auth/register',[AuthController::class, 'create']);
Route::post('auth/login',[AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function() {

Route::resource('departamentos', DepartamentoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('equipos', EquipoController::class);
Route::resource('locals', LocalController::class);
Route::resource('marcas', MarcaController::class);
Route::get('empleadosall', [EmpleadoController::class, 'all']);
Route::get('empleadosbydepartamento', [EmpleadoController::class, 'EmpleadosByDepartamento']);
Route::get('equiposall', [EquipoController::class, 'all']);
Route::get('equiposbydepartamento', [EquipoController::class, 'EquiposByDepartamento']);
Route::get('localsall', [LocalController::class, 'all']);
Route::get('localsbydepartamento', [LocalController::class, 'LocalsByDepartamento']);
Route::get('marcasall', [MarcaController::class, 'all']);
Route::get('marcasbydepartamento', [MarcaController::class, 'MarcasByDepartamento']);
Route::get('auth/logout',[AuthController::class, 'logout']);
});