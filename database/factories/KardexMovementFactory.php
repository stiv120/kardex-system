<?php

namespace Database\Factories;

use App\Models\KardexMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\kardexMovement>
 */
class KardexMovementFactory extends Factory
{
    /**
     * El nombre del modelo que está asociado con este factory.
     *
     * @var string
     */
    protected $model = KardexMovement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->text(),
            'product_id' => $this->faker->numberBetween(0, 100),
            'quantity' => $this->faker->numberBetween(0, 100)
        ];
    }
}
