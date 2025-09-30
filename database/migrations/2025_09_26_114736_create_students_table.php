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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 45)->nullable();
            $table->string('first_name', 75)->nullable();
            $table->string('last_name', 75)->nullable();
            $table->string('contact_no', 25)->nullable();
            $table->string('parent_contact_no', 25)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('nic', 45)->nullable();
            $table->string('address', 150)->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
