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
        Schema::create('tour_translations', function (Blueprint $table) {
            $table->id();
            $table->string('tour_duration');
            $table->text('must_know'); 
            $table->string('location');
            $table->string('type');
            $table->string('governorate'); 
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->string('locale')->index(); // Stores the language code, e.g., 'en', 'ar'
            $table->string('name');
            $table->text('description');
            $table->text('services');
            $table->unique(['tour_id', 'locale']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_translations');
    }
};
