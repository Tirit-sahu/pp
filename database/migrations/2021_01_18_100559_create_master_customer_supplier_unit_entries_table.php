<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCustomerSupplierUnitEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_customer_supplier_unit_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('mCustomerSupplierId');
            $table->integer('unitId');
            $table->integer('openingUnit');
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
        Schema::dropIfExists('master_customer_supplier_unit_entries');
    }
}
