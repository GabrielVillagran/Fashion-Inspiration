<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_theApplicationReturnsSuccesfulResponse(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Inspiration Image Library');
    }
}