<?php

namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Mtr\MiniCrm\Models\Manager;

class ManagerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Manager::firstOrCreate(
            ['email' => 'admin@minicrm.loc'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true
            ]
        );

        Manager::newFactory()->count(10)->create();
    }
}