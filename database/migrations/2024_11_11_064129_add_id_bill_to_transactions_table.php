<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bill')->nullable()->after('id'); // Menambahkan kolom id_bill
            $table->foreign('id_bill')->references('id')->on('bill_of_payments')->onDelete('cascade'); // Menambahkan foreign key
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['id_bill']); // Menghapus foreign key
            $table->dropColumn('id_bill'); // Menghapus kolom id_bill
        });
    }
};