<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creando un usuario DEFAULT
        User::create([
            'name' => 'Administrador',
            'email' => 'root@snte56',
            'password' => bcrypt('root2020')
        ]);
    }
}
