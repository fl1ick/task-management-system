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
            $table->string('name'); // Nama board
            $table->text('description')->nullable(); // Deskripsi board
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang membuat board
            $table->timestamps();
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
