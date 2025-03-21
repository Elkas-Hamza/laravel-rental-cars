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
            // Add all columns that might be missing
            if (!Schema::hasColumn('cars', 'price_per_day')) {
                $table->decimal('price_per_day', 10, 2)->default(0);
            }
            
            if (!Schema::hasColumn('cars', 'transmission')) {
                $table->string('transmission')->default('automatic');
            }
            
            if (!Schema::hasColumn('cars', 'seats')) {
                $table->integer('seats')->default(5);
            }
            
            if (!Schema::hasColumn('cars', 'fuel_type')) {
                $table->string('fuel_type')->default('gasoline');
            }
            
            if (!Schema::hasColumn('cars', 'air_conditioner')) {
                $table->boolean('air_conditioner')->default(true);
            }
            
            if (!Schema::hasColumn('cars', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $columns = [
                'price_per_day',
                'transmission',
                'seats',
                'fuel_type',
                'air_conditioner',
                'description'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('cars', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
