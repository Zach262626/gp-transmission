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
        Schema::create('customer_information', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20); // changed from bigInteger
            $table->year('year');
            $table->string('make', 100);
            $table->string('model', 100);
            $table->string('vin', 17)->nullable(); // lowercase + length
            $table->string('license_plate')->nullable(); // string, not int
            $table->integer('kilometres')->nullable();
            $table->string('asset_number')->nullable(); // changed to string
            $table->longText('complaint');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_information');
    }
};
