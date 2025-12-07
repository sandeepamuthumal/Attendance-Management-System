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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name', 150)->nullable();
            $table->foreignId('subjects_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teachers_id')->constrained('teachers')->onDelete('cascade');
            $table->integer('year')->nullable();
            $table->foreignId('grades_id')->constrained('grades')->onDelete('cascade');
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
