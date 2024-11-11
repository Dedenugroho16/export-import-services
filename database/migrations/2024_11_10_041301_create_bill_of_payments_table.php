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
        Schema::create('bill_of_payments', function (Blueprint $table) {
            $table->id();
            $table->date(column: 'month');
            $table->string(column: 'no_inv');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_transaction');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('approver')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_transaction')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_of_payments');
    }
};
