<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
            'description' => 'Administrador',
        ]);

       

        //Users
        DB::table('users')->insert([
            'id' => 1,
            'rut' => env('RUT_USER_LAZOS', '11.111.111-1'),
            'nombres' => 'Usuario',
            'user_created' => 1,
            'apellido_paterno' => 'Admin',
            'apellido_materno' => 'Lazos',
            'email' => env('MAIL_USER_LAZOS', 'admin@mail.com'),
            'enabled' => true,
            'password' =>  Hash::make(env('PASS_USER_LAZOS', 'prueba123')),
            'pass_created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        //Role User
        DB::table('role_user')->insert([
            'id' => 1,
            'role_id' => 1,
            'user_id' => 1
        ]);
    }
}
