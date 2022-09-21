<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i=0; $i<10; $i++) {
            $horarios = Horario::create([
                'nombre' => 'De 7 a 8',
                'id_materia' => 1,
            ]);
        // }
    }
}
