<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hash' => $this->faker->md5(),
            'client_id' => 1,
            'price' => $this->faker->numberBetween(500, 1000),
            'date_payed' => $this->faker->dateTimeThisMonth(),
            'type' => 'TYPE_PAYMENT',
        ];
    }
}
