<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mtr\MiniCrm\Models\Customer;
use Mtr\MiniCrm\Models\Manager;
use Mtr\MiniCrm\Models\Ticket;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(Ticket::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('manager_id')->nullable();

            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum(
                'status', 
                [
                    Ticket::STATUS_NEW, 
                    Ticket::STATUS_IN_PROGRESS, 
                    Ticket::STATUS_CLOSED
                ]
            )->default(Ticket::STATUS_NEW);

            $table->timestamp('answered_at')->nullable();
            $table->text('response')->nullable();

            $table->foreign('customer_id')
                ->references('id')
                ->on(Customer::TABLE_NAME)
                ->onDeleteCascade();

            $table->foreign('manager_id')
                ->references('id')
                ->on(Manager::TABLE_NAME)
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Ticket::TABLE_NAME);
    }
};