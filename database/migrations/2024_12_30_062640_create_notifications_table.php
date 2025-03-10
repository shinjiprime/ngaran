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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Primary key

        // Foreign key to the health_facilities table
        $table->unsignedBigInteger('receiver');
        $table->foreign('receiver')->references('facility_id')->on('health_facilities')->onDelete('cascade');
        
        $table->text('message'); // Notification message
        $table->enum('status', ['pending', 'sent', 'read'])->default('pending'); // Notification status
        $table->date('date'); // Date of the notification
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
