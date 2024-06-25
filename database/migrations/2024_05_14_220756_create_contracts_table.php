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
            $table->string('code')->unique();
            $table->unsignedBigInteger('guarantor_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->decimal('initial_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('percentage', 5, 2);
            $table->decimal('profit', 10, 2);
            $table->decimal('initial', 10, 2)->nullable()->default(0.00);
            $table->enum('payment_frequency', ['WEEKLY', 'FORTNIGHTLY', 'MONTHLY'])->default('WEEKLY');
            $table->unsignedTinyInteger('payment_day_of_week')->nullable();
            $table->unsignedInteger('installments_number');
            $table->enum('status', ['APPROVED', 'REJECTED', 'ENDING'])->default('APPROVED');
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
