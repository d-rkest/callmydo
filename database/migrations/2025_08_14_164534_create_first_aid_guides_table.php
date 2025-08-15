<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('first_aid_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category');
            $table->text('steps');
            $table->string('video_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('first_aid_guides');
    }
};