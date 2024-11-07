<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameToUsersTable extends Migration
{
    /**
     * Menjalankan migrasi untuk menambah kolom 'username' ke tabel 'users'.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'username' setelah kolom 'email'
            $table->string('username')->unique()->after('email'); 
        });
    }

    /**
     * Membatalkan migrasi dan menghapus kolom 'username'.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'username'
            $table->dropColumn('username');
        });
    }
}
