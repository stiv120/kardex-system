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
        $this->user = User::factory()->create(); // Crear un usuario
    }

    public function testStoreKardexMovementIncreasesStock()
    {
        // Creamos un producto con stock inicial
        $product = Product::factory()->create(['stock' => 10]);

        // Simulamos una petición para registrar un movimiento de entrada (in)
        $data = [
            'product_id' => $product?->id,
            'type' => 'in',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, //Por la cantidad
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Kardex movement registered successfully.']);

        // Verificamos que el stock del producto se incrementó
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 15, // Stock incrementado
        ]);
    }

    public function testStoreKardexMovementDecreasesStock()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $data = [
            'product_id' => $product?->id,
            'type' => 'out',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, //Por la cantidad
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Kardex movement registered successfully.']);

        // Verificamos que el stock del producto se disminuyó
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 5, // Stock disminuido
        ]);
    }

    public function testStoreKardexMovementFailsWithInsufficientStock()
    {
        $product = Product::factory()->create(['stock' => 3]);

        $data = [
            'product_id' => $product?->id,
            'type' => 'out',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, //Por la cantidad
        ];

        $response = $this->actingAs($this->user)->postJson('/api/kardex-movements', $data);

        $response->assertStatus(422); // Código de error por stock insuficiente

        // Verificamos que el stock no ha cambiado
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 3, // El stock debe seguir igual
        ]);
    }

    public function testUpdateKardexMovement()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $kardexMovement = KardexMovement::factory()->create([
            'product_id' => $product?->id,
            'type' => 'in',
            'quantity' => 5,
            'total_price' => $product->unit_price * 5, //Por la cantidad
        ]);

        // Datos para actualizar el movimiento
        $updatedData = [
            'product_id' => $kardexMovement?->product_id,
            'type' => $kardexMovement?->type,
            'quantity' => 7,
        ];
        $response = $this->actingAs($this->user)->putJson("/api/kardex-movements/{$kardexMovement?->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Kardex movement updated successfully.']);

        // Verificamos que el stock del producto ha cambiado
        $this->assertDatabaseHas('products', [
            'id' => $product?->id,
            'stock' => 17, // Stock actualizado
        ]);
    }

    public function testDeleteKardexMovement()
    {
        $product = Product::factory()->create(['stock' => 10]);

        $kardexMovement = KardexMovement::factory()->create([
            'product_id' => $product?->id,
            'type' => 'in',
            'total_price' => $product->unit_price * 5, //Por la cantidad
            'quantity' => 5,
        ]);
        $response = $this->actingAs($this->user)->deleteJson("/api/kardex-movements/{$kardexMovement?->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Kardex movement deleted successfully.']);

        // Verificamos que el movimiento fue eliminado de la base de datos
        $this->assertDatabaseMissing('kardex_movements', [
            'id' => $kardexMovement?->id
        ]);
    }
}
