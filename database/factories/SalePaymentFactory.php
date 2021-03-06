<?php

namespace Database\Factories;

use App\Models\SalePayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalePaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalePayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_type_id' => $this->faker->numberBetween(1, 10),
            'payment_status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
