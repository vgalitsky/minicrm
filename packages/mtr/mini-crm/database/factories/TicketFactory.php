<?php
namespace Mtr\MiniCrm\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'status' => TicketStatus::New,
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
            'status' => TicketStatus::New,
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
            'status' => TicketStatus::InProgress,
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
            'status' => TicketStatus::Closed,
            'answered_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'response' => fake()->paragraph(),
        ]);
    }

}