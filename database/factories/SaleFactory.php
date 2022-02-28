<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'warehouse_id' => $this->faker->numberBetween(1, 10),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'shipping_fee' => $this->faker->randomFloat(2, 1, 100),
            'is_complete' => $this->faker->boolean(),
            'payment_id' => $this->faker->numberBetween(1, 10),
            'delivery_id' => $this->faker->numberBetween(1, 10),
            'order_date' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
            'note' => $this->faker->text(100),
        ];
    }
}
