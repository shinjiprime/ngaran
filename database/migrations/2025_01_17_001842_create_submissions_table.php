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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('facility_id'); // Foreign key
            $table->date('date'); // Date column
            $table->timestamps(); // Adds created_at and updated_at columns

            // Foreign key constraint
            $table->foreign('facility_id')->references('facility_id')->on('health_facilities')->onDelete('cascade');
        // Optional: Delete submissions if the health facility is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
