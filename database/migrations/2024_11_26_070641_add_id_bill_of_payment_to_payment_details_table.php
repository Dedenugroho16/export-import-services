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
        Schema::table('payment_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bill_of_payment')->nullable()->after('id');
            $table->foreign('id_bill_of_payment')->references('id')->on('bill_of_payments')->onDelete('cascade'); // Menambahkan foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_details', function (Blueprint $table) {
            $table->dropForeign(['id_bill_of_payment']);
            $table->dropColumn('id_bill_of_payment');
        });
    }
};
