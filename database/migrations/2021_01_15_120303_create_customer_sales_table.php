<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_sales', function (Blueprint $table) {
            $table->id();
            $table->date('billDate')->nullable();
            $table->integer('farmerId')->nullable();
            $table->integer('itemId')->nullable();
            $table->double('rate', 8, 2)->nullable();
            $table->integer('unitId')->nullable();
            $table->integer('customerId')->nullable();
            $table->double('weight', 8, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->double('Amount', 8, 2)->nullable();
            $table->string('remark')->nullable();
            $table->integer('is_complete')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('createdById')->nullable();            
            $table->string('ipAddress')->nullable();
            $table->string('session')->nullable();
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
        Schema::dropIfExists('customer_sales');
    }
}
