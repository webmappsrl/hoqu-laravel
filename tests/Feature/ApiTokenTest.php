<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTokenTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReadFail()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        $token_fake = 'token-fake';

        // NO TOKEN: assert 401
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->get('/api');
        $response->assertStatus(401);

        // WRONG TOKEN: assert 401
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token_fake,
        ])->get('/api');
        $response->assertStatus(401);

        // Check that instance@webmapp.it access to api/
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['test-token@webmapp.it'],
        ])->get('/api');
        $response->assertStatus(403);

    }

    public function testReadDone()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        // Check that server@webmapp.it access to api/
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it'],
        ])->get('/api');
        $response->assertStatus(200);
        $response->assertJson([]);
        $this->assertSame($response['name'],'HOQU-API');
        $this->assertSame($response['version'],'0.1.0');
    }
}
