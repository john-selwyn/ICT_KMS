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
        Schema::table('approve_entries', function (Blueprint $table) {
            $table->softDeletes(); // Adds the 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('approve_entries', function (Blueprint $table) {
            if (Schema::hasColumn('approve_entries', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }

};
