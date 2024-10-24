<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /**
     * Set up the environment for each test.
     * Creates a new user instance.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Create a user
    }

    /**
     * Test the store method for products.
     * Ensures that a new product can be created and checks if it's stored in the database.
     * @return void
     */
    public function testStore()
    {
        $data = [
            'name' => 'Test Product',
            'unit_price' => 19.50,
            'stock' => 100
        ];

        $response = $this->actingAs($this->user)->postJson('/api/products', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Product created successfully.']);

        // Verify that the product is in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'unit_price' => 19.50,
            'stock' => 100
        ]);
    }

    /**
     * Test the index method for products.
     * Ensures that the correct number of products is returned.
     * @return void
     */
    public function testIndex()
    {
        Product::factory()->count(3)->create(); // Create 3 products

        $response = $this->actingAs($this->user)->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3); // Check that 3 products are returned
    }

    /**
     * Test the show method for a product.
     * Ensures that a specific product can be retrieved by its ID.
     * @return void
     */
    public function testShow()
    {
        $product = Product::factory()->create(); // Create a product

        $response = $this->actingAs($this->user)->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJson($product->toArray()); // Check that the product data matches
    }

    /**
     * Test the update method for products.
     * Ensures that a product can be updated and verifies the changes in the database.
     * @return void
     */
    public function testUpdate()
    {
        $product = Product::factory()->create(); // Create a product

        $updatedData = [
            'name' => 'Updated Product',
            'unit_price' => 2000,
            'stock' => 150
        ];

        $response = $this->actingAs($this->user)->putJson("/api/products/{$product->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product updated successfully.']);

        // Verify that the product has been updated in the database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'unit_price' => 2000,
            'stock' => 150
        ]);
    }

    /**
     * Test the destroy method for products.
     * Ensures that a product can be deleted and verifies its removal from the database.
     * @return void
     */
    public function testDestroy()
    {
        $product = Product::factory()->create(); // Create a product

        $response = $this->actingAs($this->user)->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully.']);

        // Verify that the product no longer exists in the database
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
