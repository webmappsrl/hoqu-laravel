<?php

namespace Tests\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

use App\Models\DuplicateTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class jobsByInstanceApiTest extends TestCase
{
    public function testTokenCreateShowFail()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );
        $response = $this->get('http://hoqu-laravel.test/api/jobsByInstance/Voluptates ullam');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->get('http://hoqu-laravel.test/api/jobsByInstance/Voluptates ullam');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['delete']
        );
        $response = $this->get('http://hoqu-laravel.test/api/jobsByInstance/Voluptates ullamvendo');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $response = $this->get('http://hoqu-laravel.test/api/jobsByInstance/Voluptates ullam');
        $response->assertStatus(200);
    }

    public function testJobsByInstance()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $response = $this->get('http://hoqu-laravel.test/api/jobsByInstance/test.cyclando.com');
        $todo = count($response['todo']);
        for ($i = 0; $i< $todo; $i++)
        {
            $this->assertSame($response['todo'][$i]['instance'],'test.cyclando.com');
            if ($response['todo'][$i]['process_status']=='new') $this->assertSame($response['todo'][$i]['process_status'],'new');
            if ($response['todo'][$i]['process_status']=='processing') $this->assertSame($response['todo'][$i]['process_status'],'processing');
            if ($i<$todo-1)
            {
                $t1 = strtotime($response['todo'][$i]['created_at']);
                $t2 = strtotime($response['todo'][$i+1]['created_at']);
                $this->assertGreaterThanOrEqual( $t2, $t1 );
            }

        }

        $done = count($response['done']);
        for ($i = 0; $i< $done; $i++)
        {
            $this->assertSame($response['done'][$i]['instance'],'test.cyclando.com');
            $this->assertSame($response['done'][$i]['process_status'],'done');
            if ($i<$done-1)
            {
                $t1 = strtotime($response['done'][$i]['created_at']);
                $t2 = strtotime($response['done'][$i+1]['created_at']);
                $this->assertGreaterThanOrEqual( $t2, $t1 );            }

        }

        $error = count($response['error']);
        for ($i = 0; $i< $error; $i++)
        {
            $this->assertSame($response['error'][$i]['instance'],'test.cyclando.com');
            $this->assertSame($response['error'][$i]['process_status'],'error');
            if ($i<$error-1)
            {
                $t1 = strtotime($response['error'][$i]['created_at']);
                $t2 = strtotime($response['error'][$i+1]['created_at']);
                $this->assertGreaterThanOrEqual( $t2, $t1 );            }

        }
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }
}
