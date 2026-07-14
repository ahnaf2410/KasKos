<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_payments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // Sesuai ERD: int

            $table->integer('user_id'); // Penghuni yang membayar
            $table->string('title'); // Contoh: Sewa kamar Juli
            $table->decimal('amount', 15, 2);
            $table->date('due_date');

            $table->enum('status', [
                'unpaid',
                'pending_verification',
                'paid'
            ])->default('unpaid');

            $table->string('payment_slip')->nullable();
            $table->date('payment_date')->nullable();

            $table->integer('verified_by')->nullable(); // Admin yang verifikasi

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('verified_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_payments');
    }
};
//benerin migration ini
