<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('move_room_requests', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->integer('user_id');
            $table->integer('from_room_id');
            $table->integer('to_room_id');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('notes')->nullable();
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('to_room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('move_room_requests');
    }
};

