<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SingleUserSeeder extends Seeder
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

        $user = User::factory()->create([

            'name'=>'webmapp',
            'email'=>'team@webmapp.it',
            'password'=>bcrypt('webmapp')

        ]);
        $token = $user->createToken('instance-token',["read","create","update","delete"])->plainTextToken;
        $tokens['team@webmapp.it']=$token;

        // SAVE TOKENS to file that will be used by TESTS
        // storage/app/test_data/tokens_text.json
        Storage::makeDirectory('test_data');
        Storage::put('test_data/tokens_users.json',json_encode($tokens));

    }
}
