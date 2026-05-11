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
         Schema::table(Customer::tableName(), function (Blueprint $table) {

            $table->string('email')
                ->nullable(false)
                ->change();

            $table->string('phone', 32)
                ->nullable(false)
                ->change();

            $table->unique(['email', 'phone']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table(Customer::tableName(), function (Blueprint $table) {

            $table->string('email')
                ->nullable()
                ->change();

            $table->string('phone', 32)
                ->nullable()
                ->change();
        });
    }
};