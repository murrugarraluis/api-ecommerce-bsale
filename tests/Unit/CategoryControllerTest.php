<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    private string $resource = 'categories';

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson("api/v1/$this->resource");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]]);
    }

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $category = Category::factory()->create(["name" => 'Category Test']);
        $response = $this->getJson("api/v1/$this->resource/$category->id");
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id',
                'name'
            ]]);
    }

    public function test_show_not_found()
    {
        $response = $this->getJson("api/v1/$this->resource/100");
        $response->assertStatus(404)
            ->assertExactJson(['message' => "Unable to locate the category you requested."]);
    }

    public function test_show_products()
    {
        $this->withoutExceptionHandling();
        $category = Category::factory()
            ->has(Product::factory()->count(3))
            ->create(["name" => 'Category Test']);
        $response = $this->getJson("api/v1/$this->resource/$category->id/products");
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
