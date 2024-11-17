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
        Schema::table('approve_entries', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('pending_entries', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approve_entries', function (Blueprint $table) {
            $table->string('category')->nullable();
        });

        Schema::table('pending_entries', function (Blueprint $table) {
            $table->string('category')->nullable();
        });
    }
};
