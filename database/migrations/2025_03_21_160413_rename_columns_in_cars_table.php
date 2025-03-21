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
        Schema::table('cars', function (Blueprint $table) {
            // Check if the old columns exist and rename them
            if (Schema::hasColumn('cars', 'marque') && !Schema::hasColumn('cars', 'brand')) {
                $table->renameColumn('marque', 'brand');
            }
            
            if (Schema::hasColumn('cars', 'prix_journalier') && !Schema::hasColumn('cars', 'price_per_day')) {
                $table->renameColumn('prix_journalier', 'price_per_day');
            }
            
            if (Schema::hasColumn('cars', 'disponible') && !Schema::hasColumn('cars', 'status')) {
                // We need to convert boolean disponible to string status
                // This is handled separately after creating the column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'brand') && !Schema::hasColumn('cars', 'marque')) {
                $table->renameColumn('brand', 'marque');
            }
            
            if (Schema::hasColumn('cars', 'price_per_day') && !Schema::hasColumn('cars', 'prix_journalier')) {
                $table->renameColumn('price_per_day', 'prix_journalier');
            }
        });
    }
};
