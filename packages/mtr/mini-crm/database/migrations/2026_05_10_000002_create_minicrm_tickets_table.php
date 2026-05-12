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

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('manager_id')->nullable();

            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum(
                'status', TicketStatus::values()
            )->default(TicketStatus::New);

            $table->text('response')->nullable();
            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->index('status')
            ->whereIn('status', [
                TicketStatus::New,
                TicketStatus::InProgress,
            ])
            ;


            $table->foreign('customer_id')
                ->references('id')
                ->on(Customer::tableName())
                ->onDeleteCascade();

            $table->foreign('manager_id')
                ->references('id')
                ->on(Manager::tableName())
                ->nullOnDelete();

            
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