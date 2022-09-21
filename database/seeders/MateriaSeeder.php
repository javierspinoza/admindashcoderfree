<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materias = [
            'Fisica',
            'Quimica',
            'Artistica',
            'Algebra',
            'Catedra',

        ];
        // for ($i=0; $i<10; $i++) {
            foreach ($materias as $materia) {
                Materia::create([
                    'nombre' => $materia
                ]);
            }
        // }

        // $materias = Materia::create([
        //     'nombre' => 'Fisica',
        // ]);
    }
}
