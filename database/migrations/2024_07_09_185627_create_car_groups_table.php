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
        Schema::create('car_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('prices');
            $table->longText('kilometers');
            $table->longText('km_packages')->nullable();
            $table->longText('insurance_packages')->nullable();
            $table->unsignedBigInteger('company_id'); // company_id sütunu eklendi
            $table->timestamps();

            // Foreign key constraint (Eğer companies tablosu varsa)
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_groups');
    }
};
