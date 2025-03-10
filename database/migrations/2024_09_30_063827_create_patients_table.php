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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patients_id');
            $table->string('patient_fname');
            $table->string('patient_minitial')->nullable();
            $table->string('patient_lname');
            $table->string('patient_extension')->nullable();
            
            $table->unsignedBigInteger('disease_code');
            $table->foreign('disease_code')->references('disease_code')->on('diseases')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onUpdate('cascade')->onDelete('cascade');
           
            $table->date('date');
            $table->integer('age');
            $table->string('age_unit');
            $table->string('gender');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
