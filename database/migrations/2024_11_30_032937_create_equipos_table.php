<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('ram',100);
            $table->string('procesador',100);
            $table->string('graficos',100);
            $table->string('monitor',100);
            $table->string('hd',100);
            $table->text('descripcion',200);
            $table->string('imagen')->nullable(); // Este campo debe ser nullable
            $table->foreignId('departamento_id')->constrained('departamentos')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};