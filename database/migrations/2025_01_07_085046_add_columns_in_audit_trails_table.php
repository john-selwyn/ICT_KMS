<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->string('performed_by_user_name')->nullable();
            $table->string('affected_user_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            //
        });
    }
};
