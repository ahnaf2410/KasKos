<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // Sesuai ERD: int
            $table->integer('bill_category_id'); // Sesuai ERD: int
            $table->string('title');
            $table->decimal('total_bill', 15, 2);
            $table->string('period'); // Format YYYY-MM
            $table->date('due_date');
            $table->integer('created_by'); // Sesuai ERD: int
            $table->timestamps();

            $table->foreign('bill_category_id')->references('id')->on('bill_categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
