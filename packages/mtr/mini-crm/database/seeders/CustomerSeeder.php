<?php
namespace Mtr\MiniCrm\Database\Seeders;

use Illuminate\Database\Seeder;
use Mtr\MiniCrm\Models\Customer;

class CustomerSeeder extends Seeder
{
    const FAKE_CUSTOMERS_COUNT = 10;
    /**
     * @return void
     */
    public function run(): void
    {
        Customer::newFactory()->count(self::FAKE_CUSTOMERS_COUNT)->create();
    }
}