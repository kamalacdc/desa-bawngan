<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('population_data', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique();
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->integer('total_families')->default(0);
            $table->json('age_groups')->nullable();
            $table->json('education_levels')->nullable();
            $table->json('occupation_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('population_data');
    }
};
