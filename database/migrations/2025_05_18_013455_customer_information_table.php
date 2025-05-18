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
            $table->date('date');
            $table->string('email');
            $table->bigInteger('cell_phone')->nullable();
            $table->bigInteger(column: 'home_phone')->nullable();
            $table->smallInteger('year');
            $table->string(column: 'make');
            $table->string(column: 'model');
            $table->string('VIN');
            $table->string(column: 'license_plate');
            $table->integer('kilometres');
            $table->integer('asset_number');
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
