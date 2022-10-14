<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    private string $resource = 'products';

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson("api/v1/$this->resource");
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'urlImage',
                    'price',
                    'discount',
                ]
            ]]);
    }
    public function test_index_search()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson("api/v1/$this->resource?name=example");
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'urlImage',
                    'price',
                    'discount',
                ]
            ]]);
    }
}
