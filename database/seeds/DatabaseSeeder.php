<?php

use Illuminate\Database\Seeder;
//use UsersRoleTableSeeder;
//use UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersRoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
