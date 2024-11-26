<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('desc_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaction');
            $table->unsignedBigInteger('id_bill');
            $table->string('description');
            $table->decimal('paid', 10, 2);
            $table->timestamps();

            $table->foreign('id_transaction')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('id_bill')->references('id')->on('bill_of_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desc_bills');
    }
};
