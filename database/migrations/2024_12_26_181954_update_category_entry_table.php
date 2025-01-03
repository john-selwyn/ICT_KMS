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
        Schema::table('category_entry', function (Blueprint $table) {
            // Rename the foreign key to make it flexible for both models
            $table->unsignedBigInteger('approved_entries_id')->nullable()->after('pending_entries_id');
    
            // Add foreign key constraints (optional)
            $table->foreign('approved_entries_id')->references('id')->on('approve_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
