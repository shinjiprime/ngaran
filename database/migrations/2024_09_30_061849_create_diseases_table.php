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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id('disease_code');
            $table->string('disease_name');
            $table->string('icd10_code');
            
            

            $table->unsignedBigInteger('disease_group_id');
            $table->foreign('disease_group_id')->references('id')->on('disease_groups')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
