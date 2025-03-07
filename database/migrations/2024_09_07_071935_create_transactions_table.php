<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->string('number');
            $table->unsignedBigInteger('id_consignee');
            $table->string('notify');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_client_company');
            $table->string('port_of_loading');
            $table->string('place_of_receipt');
            $table->string('port_of_discharge');
            $table->string('place_of_delivery');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_commodity');
            $table->string('container');
            $table->integer('net_weight');
            $table->decimal('gross_weight', 8, 2);
            $table->string('payment_term');
            $table->date('stuffing_date')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('container_number')->nullable();
            $table->string('seal_number')->nullable();
            $table->string('product_ncm');
            $table->string('payment_condition');
            $table->decimal('freight_cost', 10, 2);
            $table->decimal('total', 10, 2);
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('approver')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamps();

            $table->foreign('id_consignee')->references('id')->on('consignees')->onDelete('cascade');
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_commodity')->references('id')->on('commodities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
