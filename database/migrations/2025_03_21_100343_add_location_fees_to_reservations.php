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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('pickup_location')->nullable()->after('date_fin');
            $table->string('return_location')->nullable()->after('pickup_location');
            $table->decimal('pickup_fee', 8, 2)->default(0)->after('return_location');
            $table->decimal('return_fee', 8, 2)->default(0)->after('pickup_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('pickup_location');
            $table->dropColumn('return_location');
            $table->dropColumn('pickup_fee');
            $table->dropColumn('return_fee');
        });
    }
};
