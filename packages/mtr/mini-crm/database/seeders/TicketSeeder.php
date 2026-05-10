<?php

namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Models\Manager;
use Mtr\MiniCrm\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $customers = Customer::query()->pluck('id')->toArray();
        $managers = Manager::query()->pluck('id')->toArray();

        if (empty($customers) || empty($managers)) {
            $this->command->error('No customers or managers found');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
        
            $status = fake()->randomElement([
                Ticket::STATUS_NEW,
                Ticket::STATUS_IN_PROGRESS,
                Ticket::STATUS_CLOSED,
            ]);

            $factory = Ticket::factory();

            $factory = match ($status) {
                Ticket::STATUS_NEW => $factory->statusNew(),
                Ticket::STATUS_IN_PROGRESS => $factory->inProgress(),
                Ticket::STATUS_CLOSED => $factory->closed(),
            };

            $factory->create([
                'customer_id' => fake()->randomElement($customers),
                'manager_id' => $status === Ticket::STATUS_NEW 
                    ? null 
                    : fake()->randomElement($managers),
            ]);
        }
    }
}