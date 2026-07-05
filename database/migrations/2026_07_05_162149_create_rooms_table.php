<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // Sesuai ERD: int
            $table->string('room_number');
            $table->integer('floor');
            $table->decimal('rental_price', 15, 2);
            $table->enum('status', ['vacant', 'occupied'])->default('vacant');
            $table->integer('tenant_id')->nullable(); // Sesuai ERD: int, nullable
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};