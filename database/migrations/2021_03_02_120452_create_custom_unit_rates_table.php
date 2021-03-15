<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomUnitRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_unit_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('partyId');
            $table->integer('unitId');
            $table->double('rate', 8, 2);
            $table->integer('createdById')->nullable();
            $table->string('ipAddress')->nullable();  
            $table->integer('companyId')->nullable();
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
        Schema::dropIfExists('custom_unit_rates');
    }
}
