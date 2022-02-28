<?php

namespace Database\Factories;

use App\Models\GoogleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoogleCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GoogleCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'category_name' => $this->faker->unique()->name(),
        ];
    }
}
