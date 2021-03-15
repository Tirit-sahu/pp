<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierCarretReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_carret_returns', function (Blueprint $table) {
            $table->id();
            $table->string('receptNo');
            $table->date('date');
            $table->integer('supplierId');
            $table->integer('unitId');
            $table->integer('qty');
            $table->string('vehicleNumber');
            $table->string('driverMobile');
            $table->integer('isComplete');    
            $table->integer('createdById')->nullable();
            $table->integer('companyId')->nullable();
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
        Schema::dropIfExists('supplier_carret_returns');
    }
}
