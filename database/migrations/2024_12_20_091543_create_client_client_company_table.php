<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientClientCompanyTable extends Migration
{
    public function up()
    {
        Schema::create('client_client_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('client_company_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('client_company_id')->references('id')->on('client_company')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_client_company');
    }
}
