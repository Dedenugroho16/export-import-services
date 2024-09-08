<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsigneesTable extends Migration
{
    public function up()
    {
        Schema::create('consignees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('tel');
            $table->unsignedBigInteger('id_client');
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consignees');
    }
}
