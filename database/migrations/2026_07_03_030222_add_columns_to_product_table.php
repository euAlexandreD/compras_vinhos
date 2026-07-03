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
            $table->string('name_wine');
            $table->string('type')->nullable();
            $table->string('harvest')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('grape')->nullable();
            $table->string('volume')->nullable();
            $table->string('alcohol_content')->nullable();
            $table->string('temperature')->nullable();
            $table->string('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
