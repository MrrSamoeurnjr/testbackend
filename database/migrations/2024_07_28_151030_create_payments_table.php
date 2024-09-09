<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->decimal('paid_amount', 10, 2)->nullable(false);
            $table->decimal('total', 10, 2)->nullable(false);
            $table->timestamps();
            $table->enum('methods', ['cash', 'credit_card'])->nullable(false);
            $table->enum('status', ['unpaid', 'indebted', 'paid_off'])->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
