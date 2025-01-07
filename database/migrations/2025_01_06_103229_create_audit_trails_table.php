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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->unsignedBigInteger('performed_by');
            $table->unsignedBigInteger('affected_user_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('affected_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
