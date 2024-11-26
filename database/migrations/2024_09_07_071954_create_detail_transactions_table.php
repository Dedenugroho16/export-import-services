<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaction');
            $table->unsignedBigInteger('id_detail_product');
            $table->integer('qty');
            $table->integer('carton');
            $table->integer('inner_qty_carton');
            $table->decimal('unit_price', 10, 2);
            $table->integer('net_weight');
            $table->decimal('price_amount');
            $table->timestamps();

            $table->foreign('id_transaction')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('id_detail_product')->references('id')->on('detail_products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transactions');
    }
}
