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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('date_of_birth');
            $table->longText('identity');
            $table->longText('driving_licence');
            $table->string('company_name');
            $table->string('phone');
            $table->string('email');
            $table->longText('address');
            $table->bigInteger('invoice_status');
            $table->longText('invoice_info');
            $table->integer('status')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
