<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            "name" => 'Idsign Dev',
            "email" => 'dev@idsign.it',
            "password" => bcrypt('Idsign2018#')
        ]);

        User::create([
            "name" => 'Domenico Rizzo',
            "email" => 'd.rizzo@idsign.it',
            "password" => bcrypt('Idsign2018#')
        ]);
    }
}
