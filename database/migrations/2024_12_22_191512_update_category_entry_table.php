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
            $table->renameColumn('entry_id', 'pending_entries_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_entry', function (Blueprint $table) {
            $table->renameColumn('pending_entries_id', 'entry_id');
        });
    }
};
