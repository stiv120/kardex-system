<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\KardexMovement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KardexMovementControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Create a user
    }

    public function testStoreKardexMovementIncreasesStock()
    {
        // Create a product with initial stock
        $product = Product::factory()->create(['stock' => 10]);

        // Simulate a request to register an incoming movement (in)
        $data = [
            'product_id' => $product?->id,
            'type' => 'in',
            'quantity' => 5,
            'total_price' => $product?->unit_price * 5, // By quantity
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Kardex movement registered successfully.']);

        // Check that the stock of the product has increased
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 15, // Stock increased
        ]);
    }

    public function testStoreKardexMovementDecreasesStock()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $data = [
            'product_id' => $product?->id,
            'type' => 'out',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, // By quantity
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Kardex movement registered successfully.']);

        // Check that the stock of the product has decreased
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 5, // Stock decreased
        ]);
    }

    public function testStoreKardexMovementFailsWithInsufficientStock()
    {
        $product = Product::factory()->create(['stock' => 3]);

        $data = [
            'product_id' => $product?->id,
            'type' => 'out',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, // By quantity
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(422); // Error code for insufficient stock

        // Check that the stock has not changed
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 3, // The stock should remain the same
        ]);
    }

    public function testUpdateKardexMovement()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $kardexMovement = KardexMovement::factory()->create([
            'product_id' => $product?->id,
            'type' => 'in',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, // By quantity
        ]);

        // Data to update the movement
        $updatedData = [
            'product_id' => $kardexMovement?->product_id,
            'type' => $kardexMovement?->type,
            'quantity' => 7,
        ];
        $response = $this->actingAs($this->user)->putJson("/api/kardex-movements/{$kardexMovement?->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Kardex movement updated successfully.']);

        // Check that the stock of the product has changed
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 22, // Stock updated
        ]);
    }

    public function testDeleteKardexMovement()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $kardexMovement = KardexMovement::factory()->create([
            'product_id' => $product?->id,
            'type' => 'in',
            'total_price' => $product->unit_price * 5, // By quantity
            'quantity' => 5,
        ]);
        $response = $this->actingAs($this->user)->deleteJson("/api/kardex-movements/{$kardexMovement?->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Kardex movement deleted successfully.']);

        // Check that the movement was deleted from the database
        $this->assertDatabaseMissing('kardex_movements', [
            'id' => $kardexMovement?->id
        ]);
    }
}
