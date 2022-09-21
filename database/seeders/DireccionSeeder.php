<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Direccion;

class DireccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $direcciones = Direccion::create([
            'name' => 'Calle 24 # 12-60',
            'departamento_id' => 1,
            'ciudad_id' => 1,
            'barrio_id' => 1,
        ]);
    }
}
