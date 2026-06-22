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
        Schema::table('customer_information', function (Blueprint $table) {
            $table->date('preferred_date')->nullable()->after('asset_number');
            $table->string('preferred_time', 20)->nullable()->after('preferred_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_information', function (Blueprint $table) {
            $table->dropColumn(['preferred_date', 'preferred_time']);
        });
    }
};
