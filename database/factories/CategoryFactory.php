<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'parent_id' => $this->faker->numberBetween(1, 10),
            'tax_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(100),
            'google_category_id' => $this->faker->numberBetween(1000, 1010),
            'facebook_category_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
