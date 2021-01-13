<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Test\Feature\Artisan;

class ArtisanPruneTest extends TestCase
{
    public function test_artisan_hoqu_prune_task()
    {
        $this->artisan('hoqu:pruneTask montepisano.org Et. processing')
             ->expectsOutput('the commands have been entered correctly')
             ->assertExitCode(0);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}
