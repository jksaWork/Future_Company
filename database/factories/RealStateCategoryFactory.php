<?php

namespace Database\Factories;

use App\Models\RealStateCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealStateCategory>
 */
class RealStateCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => RealStateCategory::TYPES[random_int(0,1)],
        ];
    }
}
