<?php

namespace Database\Factories;

use App\Enum\EnumGptModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientTokenUsage>
 */
class ClientTokenUsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => 1,
            'gpt_model_code' => $gptModel = $this->faker->randomElement(array_column(EnumGptModel::cases(), 'value')),
            'prompt_count_token_in' => $in = $this->faker->numberBetween(0, 1500),
            'prompt_count_token_out' => $out = $this->faker->numberBetween(0, 1500),
            'price_token_in' => app()->get(\App\Repository\RepositoryGptModel::class)->getByCode($gptModel)->priceIn * $in,
            'price_token_out' => app()->get(\App\Repository\RepositoryGptModel::class)->getByCode($gptModel)->priceOut * $out,
            'element_id' => $this->faker->numberBetween(1, 1000),
            'task_id' => $this->faker->numberBetween(80, 120),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
