<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bill_category_logs', function (Blueprint $table) {
            $table->decimal('old_price', 15, 2)->nullable()->after('category_name');
            $table->decimal('new_price', 15, 2)->nullable()->after('old_price');
        });
    }

    public function down(): void
    {
        Schema::table('bill_category_logs', function (Blueprint $table) {
            $table->dropColumn(['old_price', 'new_price']);
        });
    }
};

