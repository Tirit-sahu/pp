<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCustomerSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_customer_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nameHindi')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->double('openingBalance', 8, 2)->nullable();
            $table->double('creditLimitAmount', 8, 2)->nullable();
            $table->double('creditLimitTransaction', 8, 2)->nullable();
            $table->string('type')->nullable();
            $table->text('groupName')->nullable();
            $table->text('openingSPN')->nullable();
            $table->text('openingTMN')->nullable();
            $table->text('openingTVS')->nullable();
            $table->string('photo')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('master_customer_suppliers');
    }
}
