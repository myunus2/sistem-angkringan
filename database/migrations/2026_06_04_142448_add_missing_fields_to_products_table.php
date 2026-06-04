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
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->nullable()->after('price');
            $table->foreignId('category_id')->nullable()->after('type');
            $table->text('description')->nullable()->after('category_id');
            $table->text('composition')->nullable()->after('description');
            $table->string('model_3d')->nullable()->after('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'category_id', 'description', 'composition', 'model_3d']);
        });
    }
};
