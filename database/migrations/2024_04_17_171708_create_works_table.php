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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('work_number', 20)->nullable();
            $table->dateTime('date_work')->nullable();
            $table->string('cows_seeded', 20)->nullable();
            $table->string('cows_palpated', 20)->nullable();
            $table->string('cows_calved', 20)->nullable();
            $table->string('price_overall', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->text('fast_notes')->nullable();
            $table->foreignId('farms_id')->nullable()->constrained('farms');
            $table->foreignId('user_veterinarian_charge_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
