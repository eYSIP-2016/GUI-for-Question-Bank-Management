<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use database\seeds\ProjectsTableSeeder;
use database\seeds\TasksTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       Model::unguard();
 
		$this->call(ProjectsTableSeeder::class);
		$this->call(TasksTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
