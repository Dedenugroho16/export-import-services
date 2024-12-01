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
        Schema::table('payment_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_client_company')->after('id_client')->nullable();
            $table->foreign('id_client_company')->references('id')->on('client_company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_details', function (Blueprint $table) {
            $table->dropForeign(['id_client_company']);
            $table->dropColumn('id_client_company');
        });
    }
};