<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMedicationsTable extends Migration
{
    public function up()
    {
        Schema::create('report_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->string('dosage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_medications');
    }
}