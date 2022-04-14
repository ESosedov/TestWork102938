<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name(),
            'position' => Arr::random(['engineer',  'developer', 'accountant', 'cleaner', 'manager']),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime()

        ];
    }
}
