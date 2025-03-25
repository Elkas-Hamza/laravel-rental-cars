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

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('color')->default('White');
            $table->string('fuel_type');
            $table->year('year');
            $table->decimal('price_per_day', 10, 2)->default(0);
            $table->boolean('disponible')->default(true);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('category')->nullable();
            $table->string('license_plate')->unique();
            $table->string('transmission')->default('automatic');
            $table->integer('seats')->default(5);
            $table->boolean('air_conditioner')->default(true);
            $table->text('description')->nullable();
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
