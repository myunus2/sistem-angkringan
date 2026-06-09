<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom phone setelah table_number, dan notes setelah total_price
            $table->string('phone')->nullable()->after('table_number');
            $table->text('notes')->nullable()->after('total_price');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['phone', 'notes']);
        });
    }
};