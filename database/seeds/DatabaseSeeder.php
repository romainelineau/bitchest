<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(
            [
                'first_name' => 'Martin',
                'last_name' => 'Dupont',
                'email' => 'dupont@la.fr',
                'password' => bcrypt('pass'),
                'role' => 'client',
            ]
        );
        App\User::create(
            [
                'first_name' => 'Romain',
                'last_name' => 'Elineau',
                'email' => 'romain.elineau@gmail.com',
                'password' => bcrypt('pass'),
                'role' => 'admin',
            ]
        );
        // $this->call(UsersTableSeeder::class);
    }
}
