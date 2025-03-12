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
        Schema::create('tbl_boards', function (Blueprint $table) {
            $table->id();
            $table->dateTime('create_time');
            $table->dateTime('update_time');
            $table->integer('create_id');
            $table->integer('update_id');
            $table->tinyInteger('archived');
            $table->string('name');
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_boards');
    }
};
