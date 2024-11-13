<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('paid', 10, 2)->default(0)->after('id_bill'); // Menambahkan kolom paid dengan 2 angka desimal
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('paid'); // Menghapus kolom paid
        });
    }
};
