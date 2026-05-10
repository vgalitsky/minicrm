<?php
namespace Mtr\MiniCrm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mtr\MiniCrm\Models\Customer;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
        ];
    }
}