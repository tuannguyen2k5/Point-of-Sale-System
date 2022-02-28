<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'price' => $this->faker->randomNumber(6, true),
            'quantity' => $this->faker->numberBetween(1, 5),
            'brand_id' => Brand::factory(),
            'expired_date' => $this->faker->date(),
            'unit_id' => Unit::factory(),
            'barcode' => $this->faker->randomNumber(9, true),
            'category_id' => Category::factory(),
            'created_by' => $this->faker->numberBetween(1, 3),
            'description' => $this->faker->text(300),
            'published' => $this->faker->boolean(),
        ];
    }
}
