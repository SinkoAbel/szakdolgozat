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
        Schema::create('reserved_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookable_reception_times_id')->constrained('bookable_reception_times')->onDelete('cascade');
            $table->foreignId('patient_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserved_bookings');
    }
};
