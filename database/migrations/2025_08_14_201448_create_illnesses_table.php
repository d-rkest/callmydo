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
        Schema::create('illnesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('symptoms');
            $table->text('local_remedy')->nullable();
            $table->text('otc_medications')->nullable(); // Over-the-counter
            $table->enum('category', ['general_illness', 'west_africa_common_illness', 'sick_cell_disease']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('illnesses');
    }
};
