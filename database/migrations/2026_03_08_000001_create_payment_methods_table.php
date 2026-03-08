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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bank', 'ewallet']); // bank atau e-wallet
            $table->string('name'); // Nama: BCA, Mandiri, GoPay, OVO, Dana
            $table->string('account_number'); // No rekening / No akun
            $table->string('account_holder'); // Nama pemilik akun
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
