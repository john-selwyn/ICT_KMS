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
            // Drop existing foreign key constraints if they exist
            $table->dropForeign(['performed_by_user_id']);
            $table->dropForeign(['affected_user_id']);

            // Modify columns to allow NULL
            $table->unsignedBigInteger('performed_by_user_id')->nullable()->change();
            $table->unsignedBigInteger('affected_user_id')->nullable()->change();

            // Add new foreign key constraints
            $table->foreign('performed_by_user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL'); // Set to NULL when user is deleted

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
            // Drop foreign key constraints
            $table->dropForeign(['performed_by_user_id']);
            $table->dropForeign(['affected_user_id']);

            // Revert columns to NOT NULL if needed
            $table->unsignedBigInteger('performed_by_user_id')->nullable(false)->change();
            $table->unsignedBigInteger('affected_user_id')->nullable(false)->change();
        });
    }
};
