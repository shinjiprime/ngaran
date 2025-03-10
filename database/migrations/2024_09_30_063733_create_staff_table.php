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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->string('staff_fname');
            $table->string('staff_mname')->nullable();
            $table->string('staff_lname');
            $table->string('staff_extension')->nullable();
            $table->string('email')->unique();
            $table->integer('phone_number');
            
            $table->unsignedBigInteger('health_facility');
            $table->foreign('health_facility')->references('facility_id')->on('health_facilities')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('rhu_id');
            $table->foreign('rhu_id')->references('rhu_id')->on('rhus')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
