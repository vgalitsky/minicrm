<?php

namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Models\Manager;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

class TicketSeeder extends Seeder
{
    const FAKE_TICKETS_COUNT = 100;

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

            $ticket = $factory->create([
                'customer_id' => fake()->randomElement($randomCustomers),
                'manager_id' => $status === TicketStatus::New
                    ? null
                    : fake()->randomElement($randomManagers),
                    'created_at' => fake()->dateTimeBetween('first day of this month'),
            ]);

            $this->fakeAttachment($ticket);
        }
    }

    /**
     * @param Ticket $ticket
     * 
     * @return void
     */
    

    private function fakeAttachment(Ticket $ticket): void
    {
        $count = fake()->numberBetween(0, 3);

        for ($i = 0; $i < $count; $i++) {
            $file = UploadedFile::fake()->image(
                name: fake()->slug() . '.jpg',
                width: 800,
                height: 600
            );

            $ticket
                ->addMedia($file)
                ->toMediaCollection(Ticket::MEDIA_ATTACHMENTS);
        }
    }
}