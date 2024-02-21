<?php

namespace Tests\Feature;

use App\Service\Api\HttpClientBus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ControllerGptPromptTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $this->mock(HttpClientBus::class, function (MockInterface $mock) {
            $mock->shouldReceive([
                'isAuth' => true
            ])->once();
        });

        $response = $this->postJson(route("gpt.prompt"), [
            "module_code" => "skyweb24.loyaltyprogram1",
            "license_key" => "S18-NA-RRJRE5THZO064OUU",
            "prompt" => "123456"
        ]);

        $response->assertJson([
            "success" => true
        ]);
    }
}
