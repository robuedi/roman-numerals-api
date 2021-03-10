<?php

namespace Tests\Controllers\Api\v1;

use App\Http\Resources\v1\NumberConversionsResource;
use App\Models\NumberConversions;
use App\Repositories\NumberConversionsRepository;
use App\Services\NumericConverter\NumericConverter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class NumeralsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
    }

    public function test_convert_roman_endpoint_value_23()
    {
        $payload = [
            'value' => 23,
        ];

        $response = $this->postJson("/api/v1/numerals/convert-roman", $payload);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'data' => [
                        'value' => 'XXIII'
                    ]
                ]
            );
    }

    public function test_index_endpoint()
    {
        //check if saved to database
        $response = $this->getJson("/api/v1/numerals");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_index_endpoint_data()
    {
        NumberConversions::factory()->count(14)->create();

        //check if saved to database
        $response = $this->getJson("/api/v1/numerals");

        $this->assertEquals(count(json_decode($response->getContent())->data), 14);
    }

    public function test_top10_endpoint()
    {
        //check if saved to database
        $response = $this->getJson("/api/v1/numerals/top-10");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_top10_endpoint_data()
    {
        NumberConversions::factory()->count(15)->create();

        //check if saved to database
        $response = $this->getJson("/api/v1/numerals/top-10");

        $this->assertEquals(count(json_decode($response->getContent())->data), 10);
    }

    public function test_convert_roman_endpoint_value_678()
    {
        $payload = [
            'value' => 678,
        ];

        $response = $this->postJson("/api/v1/numerals/convert-roman", $payload);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                [
                    'data' => [
                        'value' => 'DCLXXVIII'
                    ]
                ]
            );
    }

    public function test_convert_roman_endpoint_value_4000()
    {
        $payload = [
            'value' => 4000,
        ];

        $this->json('POST', "api/v1/numerals/convert-roman", $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_convert_roman_endpoint_value_minus_value()
    {
        $payload = [
            'value' => -2,
        ];

        $this->json('POST', "api/v1/numerals/convert-roman", $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
