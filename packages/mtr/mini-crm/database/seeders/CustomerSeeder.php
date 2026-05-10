<?php
namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Mtr\MiniCrm\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Customer::newFactory()->count(50)->create();
    }
}