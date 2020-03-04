<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Martin',
                'last_name' => 'Dupont',
                'email' => 'dupont@la.fr',
                'password'  =>  Hash::make('passwordclient'), // mot de passe crypté
                'role' => 'client'
            ]
        ]);
        DB::table('users')->insert([
            [
                'first_name' => 'Romain',
                'last_name' => 'Elineau',
                'email' => 'romain.elineau@gmail.com',
                'password'  =>  Hash::make('passwordadmin'), // mot de passe crypté
                'role' => 'admin'
            ]
        ]);
    }
}
