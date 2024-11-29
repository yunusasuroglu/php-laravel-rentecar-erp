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
            $table->longText('car')->nullable();
            $table->string('number_of_doors')->nullable();
            $table->string('horse_power')->nullable();
            $table->string('fuel')->nullable();
            $table->string('key_number')->nullable();
            $table->string('tire_size')->nullable();
            $table->string('rim_size')->nullable();
            $table->string('tire_type')->nullable();
            $table->string('color')->nullable();
            $table->longText('description')->nullable();
            $table->string('age')->nullable();
            $table->string('odometer')->nullable();
            $table->string('vin')->nullable();
            $table->string('car_group');
            $table->string('number_plate')->nullable();
            $table->date('date_to_traffic')->nullable();
            $table->integer('status')->nullable();
            $table->string('standard_exemption')->nullable();
            $table->longText('prices')->nullable();
            $table->longText('kilometers')->nullable();
            $table->longText('km_packages')->nullable();
            $table->longText('insurance_packages')->nullable();
            $table->longText('images')->nullable();
            $table->string('fuel_status')->nullable();
            $table->longText('damages')->nullable();
            $table->longText('options')->nullable();
            $table->unsignedBigInteger('company_id'); // company_id sütunu eklendi
            $table->unsignedBigInteger('group_id')->nullable(); // group_id sütunu eklendi
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('car_groups')->onDelete('cascade'); 
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
