<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    /** @use HasFactory<\Database\Factories\EquipoFactory> */
    use HasFactory;
    protected $fillable = ['ram','procesador','graficos','monitor','hd','descripcion','imagen','departamento_id'];
}
