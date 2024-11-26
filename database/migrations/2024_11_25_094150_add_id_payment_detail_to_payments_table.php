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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('id_payment_detail')->nullable()->after('id'); // Menambahkan kolom id_bill
            $table->foreign('id_payment_detail')->references('id')->on('payment_details')->onDelete('cascade'); // Menambahkan foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['id_payment_detail']); // Menghapus foreign key
            $table->dropColumn('id_payment_detail'); // Menghapus kolom id_bill
        });
    }
};
