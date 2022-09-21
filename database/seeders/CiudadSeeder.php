<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ciudades = Ciudad::create([
            'name' => 'Charala',
            'departamento_id' => 1,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'San Gil',
            'departamento_id' => 1,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Bucaramanaga',
            'departamento_id' => 1,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Medellin',
            'departamento_id' => 2,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Armenia',
            'departamento_id' => 2,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Bello',
            'departamento_id' => 2,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Usaquen',
            'departamento_id' => 3,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Chapinero',
            'departamento_id' => 3,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Santa Fe',
            'departamento_id' => 3,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Yopal',
            'departamento_id' => 4,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Tamara',
            'departamento_id' => 4,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Sabanalarga',
            'departamento_id' => 4,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Pasto',
            'departamento_id' => 5,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'Nariño',
            'departamento_id' => 5,
        ]);
        $ciudades = Ciudad::create([
            'name' => 'San Pablo',
            'departamento_id' => 5,
        ]);
    }
}
