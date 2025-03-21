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
            $table->boolean('add_gps')->default(false)->after('return_fee');
            $table->boolean('add_wifi')->default(false)->after('add_gps');
            $table->boolean('add_baby_seat')->default(false)->after('add_wifi');
            $table->boolean('add_full_tank')->default(false)->after('add_baby_seat');
            $table->decimal('accessories_fee', 8, 2)->default(0)->after('add_full_tank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('add_gps');
            $table->dropColumn('add_wifi');
            $table->dropColumn('add_baby_seat');
            $table->dropColumn('add_full_tank');
            $table->dropColumn('accessories_fee');
        });
    }
};
