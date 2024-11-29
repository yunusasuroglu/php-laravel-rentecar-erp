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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_number');
            $table->string('profile_image')->default('assets/images/default/default-profile.png');
            $table->string('logo')->default('assets/images/default/default-logo.png');
            $table->string('email');
            $table->string('phone');
            $table->string('fax');
            $table->string('hrb');
            $table->string('iban');
            $table->string('bic');
            $table->string('stnr');
            $table->string('ust_id_nr');
            $table->string('registry_court');
            $table->string('general_manager');
            $table->longText('address');
            $table->tinyInteger('status')->default(2);
            $table->string('reference_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
