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
        Schema::create('payment_history', function (Blueprint $table) {
            $table->id();
            $table->date('payment_receipt_date')->nullable();
            $table->string('amount_received', 20)->nullable();
            $table->string('outstanding_balance', 20)->nullable();
            $table->string('total_work_balance', 20)->nullable();
            $table->text('fast_notes')->nullable();
            $table->foreignId('work_id')->nullable()->constrained('works');
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
        Schema::dropIfExists('payment_history');
    }
};
