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

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('name');
            $table->string('currency_symbol')->nullable();
            $table->string('country_code')->nullable();
            $table->string('iso2', 2)->nullable();
            $table->string('status')->default('active');
            $table->json('language')->nullable();
            $table->string('flag_url')->nullable();
            $table->json('currency_meta')->nullable();
            $table->string('app_icon')->nullable();
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('countries');
    }
};
