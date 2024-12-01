<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('approve_entries', function (Blueprint $table) {
            $table->string('youtube_url')->nullable()->after('attachment');
        });

        Schema::table('pending_entries', function (Blueprint $table) {
            $table->string('youtube_url')->nullable()->after('attachment');
        });
    }

    public function down()
    {
        Schema::table('approve_entries', function (Blueprint $table) {
            $table->dropColumn('youtube_url');
        });

        Schema::table('pending_entries', function (Blueprint $table) {
            $table->dropColumn('youtube_url');
        });
    }

};
