<?php

namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;

class MiniCrmSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ManagerSeeder::class,
            CustomerSeeder::class,
            TicketSeeder::class,
        ]);
    }
}