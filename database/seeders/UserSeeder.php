<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Usuario Administrador Javier',
            'email' => 'javerespinoxzapiko@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('Admin');

        $userUsuario = User::create([
            'name' => 'Usuario Javier Usuario',
            'email' => 'jespinosa937@misena.edu.co',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678')
        ]);

        $userUsuario->assignRole('User');
    }
}
