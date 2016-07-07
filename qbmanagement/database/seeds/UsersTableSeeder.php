// app/database/seeds/UsersTableSeeder.php
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
        $users = array(
            ['id' => 1, 'name' => 'Tushar Shah', 'username' => 'tushar', 'email' => 'tusharshahsp@gmail.com', 'password' => Hash::make('tushar123'), 'user_type_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],

            ['id' => 2, 'name' => 'Bhalchandra Naik', 'username' => 'bhalchandra', 'email' => 'bnaik2611@gmail.com' , 'password' => Hash::make('bnaik123'), 'user_type_id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime],

            ['id' => 3,'name' => 'Dummy User', 'username' => 'user', 'email' => 'user123@gmail.com', 'password' => Hash::make('user123'), 'user_type_id' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime]
            
            );

         DB::table('users')->insert($users);
    }
}
