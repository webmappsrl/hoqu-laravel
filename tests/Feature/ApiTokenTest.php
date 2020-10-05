<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTokenTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $token = 'lFMcWnzCWxzPFLCry2UTK8nIPMF8UFjEcogbQKCO';
        $token_fake = '';

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token_fake,
        ])->get('/api');
        $response->assertStatus(401);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ])->get('/api');
        $response->assertStatus(200);
        $response->assertJson([]);
        $this->assertSame($response['name'],'HOQU-API');
        $this->assertSame($response['version'],'0.1.0');
    }
}
