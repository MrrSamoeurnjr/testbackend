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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable(false);
            $table->unsignedBigInteger('receiver_id')->nullable(false);
            $table->unsignedBigInteger('property_id')->nullable(false);
            $table->unsignedBigInteger('room_id')->nullable(false);
            $table->text('message')->nullable(false);
            $table->timestamps(); 
            $table->string('type', 50)->nullable(false);
            $table->enum('status', ['seen', 'unseen'])->default('unseen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
