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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->longText('customer')->nullable(); 
            $table->longText('items')->nullable();    
            $table->integer('extra_km')->nullable();
            $table->decimal('extra_km_price', 8, 2)->nullable();
            $table->longText('km_packages')->nullable();
            $table->longText('insurance_packages')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('totalprice', 10, 2)->nullable();
            $table->decimal('totalamount', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->longText('damages')->nullable();
            $table->foreignId('company_id')->constrained(); // Foreign key for the company relationship
            $table->foreignId('contract_id')->constrained(); // Foreign key for the contract relationship
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
