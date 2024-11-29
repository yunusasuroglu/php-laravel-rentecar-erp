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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('company_id');
            $table->string('car_group')->nullable();
            $table->longText('car')->nullable();
            $table->longText('customer')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('km_packages')->nullable();
            $table->longText('insurance_packages')->nullable();
            $table->string('discount')->nullable();
            $table->string('payment_option')->nullable();
            $table->longText('description')->nullable();
            $table->string('signature')->nullable();
            $table->string('user_signature')->nullable();
            $table->integer('status')->nullable();
            $table->longText('damages')->nullable();
            $table->string('extra_km')->nullable();
            $table->string('extra_km_price')->nullable();
            $table->string('fuel_status')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('remaining_paid')->nullable();
            $table->string('total_amount')->nullable();
            $table->date('pickup_date')->nullable();
            $table->string('deposit')->nullable();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
