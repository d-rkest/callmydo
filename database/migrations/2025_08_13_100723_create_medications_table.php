<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationsTable extends Migration
{
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uses');
            $table->string('potency_level');
            $table->string('recommended_dosage_children')->nullable();
            $table->string('recommended_dosage_adults');
            $table->string('side_effects');
            $table->string('contraindications');
            $table->string('storage_condition');
            $table->string('other_key_information');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medications');
    }
}