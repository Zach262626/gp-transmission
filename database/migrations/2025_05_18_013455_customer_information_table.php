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
            $table->bigInteger('phone');
            $table->smallInteger('year');
            $table->string(column: 'make');
            $table->string(column: 'model');
            $table->string('VIN')->nullable();
            $table->string(column: 'license_plate')->nullable();
            $table->integer('kilometres')->nullable();
            $table->integer('asset_number')->nullable();
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
