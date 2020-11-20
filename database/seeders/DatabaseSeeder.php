<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $tokens array only for TESTING purpose
        // $tokens['email']=$token;
        $tokens=array();

        \App\Models\User::factory(1)->create([

            'name'=>'webmapp',
            'email'=>'team@webmapp.it',
            'password'=>bcrypt('webmapp')

        ]);

        $x = \App\Models\User::factory(1)->create([

            'name'=>'instance',
            'email'=>'instance@webmapp.it',
            'password'=>bcrypt('webmapp')

        ]);

        $user = $x[0];
        $token = $user->createToken('instance-token',["read","create"])->plainTextToken;
        $tokens['instance@webmapp.it']=$token;

        $x = \App\Models\User::factory(1)->create([

            'name'=>'server',
            'email'=>'server@webmapp.it',
            'password'=>bcrypt('webmapp')

        ]);
        $user = $x[0];
        $token = $user->createToken('server-token',["read","update"])->plainTextToken;
        $tokens['server@webmapp.it']=$token;

        $x = \App\Models\User::factory(1)->create([

            'name'=>'test',
            'email'=>'test@webmapp.it',
            'password'=>bcrypt('webmapp')

        ]);

        $user = $x[0];
        $token = $user->createToken('test-token',["create"])->plainTextToken;
        $tokens['test-token@webmapp.it']=$token;

        // SAVE TOKENS to file that will be used by TESTS
        // storage/app/test_data/tokens_text.json
        Storage::makeDirectory('test_data');
        Storage::put('test_data/tokens_users.json',json_encode($tokens));

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

        // for ($i=0; $i < 100 ; $i++) {
        //     \App\Models\Task::factory()->count(1)->duplicated()->create();
        // }

        for ($i=0; $i < 5 ; $i++) {
            $task_id=rand(1,100);
            $qta=rand(1,10);

            \App\Models\DuplicateTask::factory($qta)->create(['task_id'=>$task_id]);
        }

    }
}
