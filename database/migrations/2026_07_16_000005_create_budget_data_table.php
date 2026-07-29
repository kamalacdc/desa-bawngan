<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_data', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->enum('type', ['income', 'expense']);
            $table->string('category');
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['year', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_data');
    }
};
