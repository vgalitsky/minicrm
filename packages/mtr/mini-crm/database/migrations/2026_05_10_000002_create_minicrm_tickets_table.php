<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Models\Manager;
use Mtr\MiniCrm\Models\Ticket;
use Mtr\MiniCrm\Models\Ticket\TicketStatus;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(Ticket::tableName(), function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained(Customer::tableName())
                ->cascadeOnDelete();

            $table->foreignId('manager_id')
                ->nullable()
                ->constrained(Manager::tableName())
                ->nullOnDelete();

            $table->string('subject');
            $table->text('description');
            $table->enum(
                'status', TicketStatus::values()
            )->default(TicketStatus::New->value);

            $table->text('response')->nullable();
            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->index('customer_id');

            $table->index('manager_id');

            $table->index('created_at');

            $table->index([
                'status',
                'created_at',
            ]);
            
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Ticket::tableName());
    }
};