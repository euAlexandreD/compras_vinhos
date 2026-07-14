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
        if (Schema::hasColumn('orders', 'statuses_id') && !Schema::hasColumn('orders', 'status_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('statuses_id', 'status_id');
            });
        }

        if (Schema::hasColumn('orders', 'product_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }

        if (Schema::hasColumn('orders', 'quantity')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('orders', 'quantity')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('quantity')->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'product_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            });
        }

        if (Schema::hasColumn('orders', 'status_id') && !Schema::hasColumn('orders', 'statuses_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('status_id', 'statuses_id');
            });
        }
    }
};
