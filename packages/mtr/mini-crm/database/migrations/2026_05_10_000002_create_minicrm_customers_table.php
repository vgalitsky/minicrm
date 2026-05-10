<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mtr\MiniCrm\Models\Customer;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(Customer::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',32)->unique();

            $table->index('email');
            $table->index('phone');

            $table->timestamps();

        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Customer::TABLE_NAME);
    }
};