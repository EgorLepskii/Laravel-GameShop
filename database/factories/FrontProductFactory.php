<?php

namespace Database\Factories;

use App\Models\FrontCategory;
use App\Models\FrontProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class FrontProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(FrontProduct::MAX_DESCRIPTION_LENGTH),
            'categoryId' => FrontCategory::factory(),
            'imageSrc' => '',
            'price' => $this->faker->numberBetween(0,FrontProduct::MAX_PRICE)
        ];
    }
}
