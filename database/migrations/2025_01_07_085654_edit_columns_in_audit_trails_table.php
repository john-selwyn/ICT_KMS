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
            // Modify foreign key for performed_by_user_id
            $table->foreign('performed_by_user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL'); // Set to NULL when user is deleted

            // Modify foreign key for affected_user_id
            $table->foreign('affected_user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL'); // Set to NULL when user is deleted
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
