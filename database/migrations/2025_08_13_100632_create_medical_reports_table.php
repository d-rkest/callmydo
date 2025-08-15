<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('report_type');
            $table->string('file_path');
            $table->string('status')->default('pending');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('findings')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('cause')->nullable();
            $table->text('remedy')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_reports');
    }
}