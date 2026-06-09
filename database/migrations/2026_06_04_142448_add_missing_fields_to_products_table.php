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
            if (! Schema::hasColumn('products', 'type')) {
                $table->string('type')->nullable()->after('price');
            }

            if (! Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('type');
            }

            if (! Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('category_id');
            }

            if (! Schema::hasColumn('products', 'composition')) {
                $table->text('composition')->nullable()->after('description');
            }

            if (! Schema::hasColumn('products', 'model_3d')) {
                $table->string('model_3d')->nullable()->after('images');
            }
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
