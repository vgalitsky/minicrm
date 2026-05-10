<?php
namespace Mtr\MiniCrm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mtr\MiniCrm\Models\Ticket;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(4),
            'description' => fake()->paragraph(),       
        ];
    }

    /**
     * State for New ticket
     * 
     * @return static
     */
    public function statusNew(): static
    {
        return $this->state(fn () => [
            'status' => Ticket::STATUS_NEW,
            'manager_id' => null,
            'answered_at' => null,
            'response' => null,
        ]);
    }

    /**
     * State for InProgress ticket
     * 
     * @return static
     */
    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => Ticket::STATUS_IN_PROGRESS,
            'answered_at' => null,
            'response' => null,
        ]);
    }

    /**
     * State for Closed ticket
     * 
     * @return static
     */
    public function closed(): static
    {
        return $this->state(fn () => [
            'status' => Ticket::STATUS_CLOSED,
            'answered_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'response' => fake()->paragraph(),
        ]);
    }

}