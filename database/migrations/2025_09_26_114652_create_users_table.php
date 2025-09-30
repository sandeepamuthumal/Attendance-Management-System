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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_types_id')->constrained('user_types');
            $table->string('first_name', 75)->nullable();
            $table->string('last_name', 75)->nullable();
            $table->string('phone_no', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 255)->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
