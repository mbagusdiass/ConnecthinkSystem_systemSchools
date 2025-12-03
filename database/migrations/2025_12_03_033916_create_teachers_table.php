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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nip')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('gender', ['L', 'P']);
            $table->string('expertise');
            $table->string('address');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
