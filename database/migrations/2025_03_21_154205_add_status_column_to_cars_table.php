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
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('cars', 'status')) {
                $table->string('status')->default('available')->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Remove the column if it exists
            if (Schema::hasColumn('cars', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
