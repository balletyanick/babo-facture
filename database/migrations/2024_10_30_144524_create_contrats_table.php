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
        Schema::create('contrats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('product_id', 36);
            $table->char('customer_id', 36); 
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('amount_global');
            $table->string('num_contrat');
            $table->string('type_contrat');
            $table->integer('quantite'); 
            $table->integer('dispo_retrait'); 
            $table->string('note')->nullable();
            $table->timestamps(); 
        });

        Schema::table('contrats', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
