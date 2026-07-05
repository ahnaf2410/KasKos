<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // Sesuai ERD: int
            $table->integer('bill_id'); // Sesuai ERD: int
            $table->integer('user_id'); // Sesuai ERD: int
            $table->decimal('split_amount', 15, 2); // total_bill divided by active tenants
            $table->enum('status', ['unpaid', 'pending_verification', 'paid'])->default('unpaid');
            $table->string('payment_slip')->nullable(); // file_path, nullable
            $table->date('payment_date')->nullable(); // nullable
            $table->integer('verified_by')->nullable(); // Sesuai ERD: int, nullable
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};