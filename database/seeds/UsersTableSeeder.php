<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $userRoles = array(
            [
                'id' => 1,
                'fk_users_role' => '1',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@super.com',
                'password' => bcrypt(12345678),
                'image' => '',
                'phone' => '12345678',
                'created_at' => new DateTime, 
                'updated_at' => new DateTime
            ],
            [
                'id' => 2,
                'fk_users_role' => '2',
                'first_name' => 'admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt(12345678),
                'image' => '',
                'phone' => '12345678',
                'created_at' => new DateTime, 
                'updated_at' => new DateTime
            ],
            [
                'id' => 3,
                'fk_users_role' => '3',
                'first_name' => 'Org',
                'last_name' => 'Admin',
                'email' => 'admin@org.com',
                'password' => bcrypt(12345678),
                'image' => '',
                'phone' => '12345678',
                'created_at' => new DateTime, 
                'updated_at' => new DateTime
            ],
        );
        DB::table('users')->insert($userRoles);
    }
}
