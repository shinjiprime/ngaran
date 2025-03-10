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
        // Schema::create('records', function (Blueprint $table) {
        //     $table->id('record_id');
        //     $table->string('record_type');
        //     $table->unsignedBigInteger('health_facility');
        //     $table->foreign('health_facility')->references('facility_id')->on('health_facilities')->onUpdate('cascade')->onDelete('cascade');
            
        //     $table->string('record_period');
        //     $table->unsignedBigInteger('disease_code');
        //     $table->foreign('disease_code')->references('disease_code')->on('diseases')->onUpdate('cascade')->onDelete('cascade');
            
        //     $table->integer('year');
        //     $table->integer('month');
        //     $table->integer('age_range_start');
        //     $table->integer('age_range_end');
        //     $table->string('age_unit');
        //     $table->string('gender');
        //     $table->integer('tally_count');
        //     $table->string('status')->default('pending');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
