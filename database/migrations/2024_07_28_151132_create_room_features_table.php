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
        Schema::create('room_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('status', 50)->nullable(false);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_features');
    }
};
