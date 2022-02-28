<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'address' => $this->faker->address(),
            'bank_name' => $this->faker->name(),
            'bank_account' => $this->faker->bankAccountNumber(),
            'phone' => $this->faker->phoneNumber(),
            'manager_id' => $this->faker->numberBetween(1, 3),
            'warehouse_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
