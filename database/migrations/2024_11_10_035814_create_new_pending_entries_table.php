<?php
// database/migrations/xxxx_xx_xx_create_new_pending_entries_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPendingEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('new_pending_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_pending_entries');
    }
}
