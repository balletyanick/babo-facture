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
        Schema::create('paiements', function (Blueprint $table) { 
            $table->uuid('id')->primary();
            $table->char('contrat_id', 36);
            $table->char('customer_id', 36);
            $table->integer('amount');
            $table->date('date_demande');
            $table->string('status');
            $table->string('mode_paiement');
            $table->timestamps(); 
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
