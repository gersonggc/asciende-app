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
            $table->unsignedBigInteger('guarantor_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_frequency', ['fortnightly', 'monthly']);
            $table->unsignedInteger('installments');
            $table->decimal('percentage', 5, 2);
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'ENDING'])->default('PENDING');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('terms')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        
            $table->foreign('guarantor_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
