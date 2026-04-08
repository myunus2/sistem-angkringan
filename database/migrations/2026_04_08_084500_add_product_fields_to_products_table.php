<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'type')) {
                $table->string('type')->nullable()->after('name');
            }

            if (! Schema::hasColumn('products', 'composition')) {
                $table->text('composition')->nullable()->after('price');
            }

            if (! Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('composition');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('products', 'composition')) {
                $table->dropColumn('composition');
            }

            if (Schema::hasColumn('products', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
