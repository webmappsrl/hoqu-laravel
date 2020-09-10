<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;

class listTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;

    public function testList()
    {
        Queue::truncate();
        $response = $this->get('/api/queue/list');
        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
