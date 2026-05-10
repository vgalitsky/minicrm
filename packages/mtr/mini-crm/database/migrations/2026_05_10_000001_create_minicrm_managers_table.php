<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mtr\MiniCrm\Models\Manager;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(Manager::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Manager::TABLE_NAME);
    }
};