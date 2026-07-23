<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Zaydan Azka');
        $response->assertSee('24.12.3131');
        $response->assertSee('Mirza Lazuardy');
        $response->assertSee('24.12.3132');
        $response->assertSee('Aditya Permana');
        $response->assertSee('24.12.3135');
        $response->assertSee('tidak ada tanggung jawab');
    }
}
