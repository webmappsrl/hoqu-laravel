<?php

namespace Database\Seeders;

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
         \App\Models\User::factory(1)->create([

         	'name'=>'webmapp',
         	'email'=>'team@webmapp.it',
         	'password'=>bcrypt('T1tup4atmA')

         ]);

         for ($i=0; $i < 100 ; $i++) { 
         	\App\Models\Task::factory(1)->create();
         }

         for ($i=0; $i < 100 ; $i++) { 
         	\App\Models\Task::factory()->count(1)->suspended()->create();
         }

         for ($i=0; $i < 100 ; $i++) { 
         	\App\Models\Task::factory()->count(1)->create_done()->create();
         }

         for ($i=0; $i < 100 ; $i++) { 
         	\App\Models\Task::factory()->count(1)->create_error()->create();
         }



    }
}
