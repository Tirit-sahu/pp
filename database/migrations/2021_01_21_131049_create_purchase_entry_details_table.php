<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEntryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_entry_details', function (Blueprint $table) {
            $table->id();
            $table->integer('purchaseEntryId')->default(0);
            $table->integer('itemId');
            $table->integer('rate');
            $table->integer('unitId');
            $table->integer('qty');
            $table->double('weight', 8, 2);
            $table->double('amount', 8, 2);
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
        Schema::dropIfExists('purchase_entry_details');
    }
}
