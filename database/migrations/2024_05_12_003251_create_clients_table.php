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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('names');
            $table->string('last_names');
            $table->string('dni');
            $table->string('direction');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('observations')->nullable();
            $table->boolean('active')->default(true);
            // $table->enum('contract_status', ["PENDING", "ACTIVE", "IN_PROGRESS", "TERMINATED", "REJECTED"])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
