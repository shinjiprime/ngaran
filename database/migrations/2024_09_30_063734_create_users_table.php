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
            $table->string('username');
            $table->string('password');  
            $table->integer('user_level'); // Add user_level column
            $table->unsignedBigInteger('staff_id')->nullable(); // Add staff_id as a foreign key (nullable if necessary)
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('cascade');
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
