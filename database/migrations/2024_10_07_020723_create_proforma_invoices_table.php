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
        Schema::create('proforma_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->string('number');
            $table->unsignedBigInteger('id_consignee');
            $table->string('notify');
            $table->unsignedBigInteger('id_client');
            $table->string('port_of_loading');
            $table->string('place_of_receipt');
            $table->string('port_of_discharge');
            $table->string('place_of_delivery');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_commodity');
            $table->string('container');
            $table->decimal('net_weight', 8, 2);
            $table->decimal('gross_weight', 8, 2);
            $table->string('payment_term');
            $table->string('product_ncm');
            $table->unsignedBigInteger('id_detail_product');
            $table->integer('qty');
            $table->integer('carton');
            $table->integer('inner_qty_carton');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('price_amount', 10, 2);
            $table->decimal('freight_cost', 10, 2);
            $table->decimal('total', 10, 2);
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('id_consignee')->references('id')->on('consignees')->onDelete('cascade');
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_commodity')->references('id')->on('commodities')->onDelete('cascade');
            $table->foreign('id_detail_product')->references('id')->on('detail_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proforma_invoices');
    }
};
