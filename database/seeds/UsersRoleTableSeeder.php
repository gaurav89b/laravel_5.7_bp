<?php

use Illuminate\Database\Seeder;

class UsersRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users_role')->delete();
        $userRoles = array(
            ['id' => 1, 'name' => 'Super Admin', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'Admin', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'Organisation Admin', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 4, 'name' => 'Tutor', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 5, 'name' => 'Participant', 'created_at' => new DateTime, 'updated_at' => new DateTime]
        );
        DB::table('users_role')->insert($userRoles);
    }
}