<?php
namespace Mtr\MiniCrm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mtr\MiniCrm\Models\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerFactory extends Factory
{
    protected $model = Manager::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
//            'is_admin' => false,
        ];
    }

    // /**
    //  * @return static
    //  */
    // public function admin(): static
    // {
    //     return $this->state(fn () => [
    //             'is_admin' => true
    //     ]);
    // }
}