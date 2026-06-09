<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'paid'])
                ->default('unpaid')
                ->after('payment_method');
            $table->timestamp('completed_at')->nullable()->after('status');
        });

        DB::table('orders')
            ->whereNotNull('payment_method')
            ->update(['payment_status' => 'paid']);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'completed_at']);
        });
    }
};
