<?php

namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Models\Manager;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class TicketSeeder extends Seeder
{
    const FAKE_TICKETS_COUNT = 20;

    /**
     * @return void
     */
    public function run(): void
    {
        if (!Customer::exists() || !Manager::exists()) {
            $this->command->error('no arms - no cackes!');
            return;
        }

        $randomCustomers = Customer::pluck('id')
            ->take(self::FAKE_TICKETS_COUNT)
            ->all();
        
        $randomManagers = Manager::pluck('id')
            ->take(self::FAKE_TICKETS_COUNT)
            ->all();

        for ($i = 0; $i < self::FAKE_TICKETS_COUNT; $i++) {
        
            $status = fake()->randomElement([
                TicketStatus::New,
                TicketStatus::InProgress,
                TicketStatus::Closed,
            ]);;

            $factory = match ($status) {
                TicketStatus::InProgress => Ticket::factory()->inProgress(),
                TicketStatus::Closed => Ticket::factory()->closed(),
                default => Ticket::factory()->statusNew(),
            };

            $factory->create([
                'customer_id' => fake()->randomElement($randomCustomers),
                'manager_id' => $status === TicketStatus::New
                    ? null
                    : fake()->randomElement($randomManagers),
            ]);
        }
    }
}