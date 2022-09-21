<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos = [
            'Santander',
            'Antioquia',
            'Bogota',
            'Casanare',
            'Nariño',

        ];
        // for ($i=0; $i<10; $i++) {
            foreach ($departamentos as $departamento) {
                Departamento::create([
                    'name' => $departamento
                ]);
            }
        // }

        // $departamentos = Departamento::create([
        //     'name' => 'Santander',
        // ]);
    }
}
