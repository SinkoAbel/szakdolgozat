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
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->date('birthday');
            $table->string('birthplace', 80);
            $table->string('city', 80);
            $table->string('zip', 10);
            $table->string('street', 50);
            $table->string('house_number', 10);
            $table->string('insurance_number', 15)->unique();
            $table->string('phone', 30)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_details');
    }
};
