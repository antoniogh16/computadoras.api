<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
            \App\Models\Departamento::factory(6)->create();
            \App\Models\Empleado::factory(25)->create();
            \App\Models\Equipo::factory(25)->create();
            \App\Models\Local::factory(2)->create();
            \App\Models\Marca::factory(5)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
