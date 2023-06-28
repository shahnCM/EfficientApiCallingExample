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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('email');
            $table->timestamps();
        });

        Schema::table('company_details', function (Blueprint $table) {
            $table->index(['symbol', 'start_date', 'end_date'], 'idx_symbol_start_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->dropIndex('idx_symbol_start_end');
        });

        Schema::dropIfExists('company_details');
    }
};
