<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('attachments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pending_entry_id'); // Changed to match the correct table
        $table->string('file_path');
        $table->timestamps();

        // Foreign key constraint referencing the correct table (pending_entries)
        $table->foreign('pending_entry_id')->references('id')->on('pending_entries')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
