<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // para ejecutar los factories
    // php artisan db:seed
    // para ejecutar los seeder
    // php artisan migrate:refresh --seed
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Materia::factory(200000)->create();
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleHasPermissionSeeder::class,
            UserSeeder::class,
            MateriaSeeder::class,
            HorarioSeeder::class,
            DepartamentoSeeder::class,
            CiudadSeeder::class,
            BarrioSeeder::class,
            DireccionSeeder::class,
        ]);
    }
}
