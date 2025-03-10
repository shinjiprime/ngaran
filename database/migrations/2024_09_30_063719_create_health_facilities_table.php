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
        Schema::create('health_facilities', function (Blueprint $table) {
            $table->id('facility_id');
            $table->string('facility_name');
            $table->integer('facility_type');
            
         
            $table->unsignedBigInteger('barangay_id')->nullable();
            
            $table->foreign('barangay_id')->references('id')->on('barangays')->onUpdate('cascade')->onDelete('cascade');
            
            
            
            $table->unsignedBigInteger('rhu_id');
            $table->foreign('rhu_id')->references('rhu_id')->on('rhus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('coordinates');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_facilities');
    }
};
