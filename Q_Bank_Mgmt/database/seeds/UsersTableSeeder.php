// app/database/seeds/UserTableSeeder.php
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
        //
        DB::table('users')->delete();
        $users = array(
            ['id' => 1, 'name' => 'Tushar Shah', 'username' => 'tushar',  'password' => 'tushar123', 'user_type_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],

            ['id' => 2, 'name' => 'Bhalchandra Naik', 'username' => 'bhalchandra',  'password' => 'bnaik123', 'user_type_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],

            ['id' => 3,'name' => 'Dummy User', 'username' => 'user',  'password' => 'user123', 'user_type_id' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime]);
             DB::table('users')->insert($users);
    }
}
