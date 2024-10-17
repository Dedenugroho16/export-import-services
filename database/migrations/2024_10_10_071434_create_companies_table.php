<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('company_name');
            $table->string('company_code')->unique();
            $table->string('registration_number')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('industry')->nullable();
            $table->string('tax_id')->nullable();
            $table->date('founded_date')->nullable();
            $table->string('export_license_number')->nullable();
            $table->string('import_license_number')->nullable();
            $table->text('bank_account_details')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('shipping_agent')->nullable();
            $table->string('customs_broker')->nullable();
            $table->string('consignee_code')->nullable();
            $table->string('forwarding_agent')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}