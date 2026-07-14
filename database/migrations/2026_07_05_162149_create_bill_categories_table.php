<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // Sesuai ERD: int
            $table->string('category_name'); // electricity, wifi, gas, trash, etc

            // PERBAIKAN: ->after() dihapus. Posisinya cukup ditaruh di bawah 'category_name' agar urutannya pas
            $table->integer('price')->default(0);

            $table->boolean('default_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_categories');
    }
};
