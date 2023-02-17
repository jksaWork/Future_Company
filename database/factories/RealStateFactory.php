<?php

namespace Database\Factories;

use App\Models\RealStateCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealState>
 */
class RealStateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                "title" => "شقه ارضيهشقه ارضيه",
                "realstate_number" => "123",
                "address" => "اي مكان بي الضبط",
                "price" => 12000000,
                "type" => "rent",
                "description" => "شقه ارضيه  شقه ارضيه  شقه ارضيه  شقه ارضيه  شقه ارضيه",
                "status" => 1,
                "is_rent" => 0,
                "is_sale" => 0,
                "category_id" => RealStateCategory::get()->random()->id,
        ];
    }
}