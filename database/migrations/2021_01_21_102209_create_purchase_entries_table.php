<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_entries', function (Blueprint $table) {
            $table->id();
            $table->date('purchaseDate');
            $table->string('receiptNumber')->nullable();
            $table->integer('supplierId');
            $table->string('vehicleNumber')->nullable();
            $table->string('billPrintName')->nullable();
            $table->string('narration')->nullable();
            $table->double('expenseAmt', 8, 2)->default(0);
            $table->double('otherChargesAmt', 8, 2)->default(0);
            $table->double('totalAmt', 8, 2)->default(0);
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
        Schema::dropIfExists('purchase_entries');
    }
}
