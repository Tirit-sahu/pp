<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadingEntryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loading_entry_details', function (Blueprint $table) {
            $table->id();
            $table->integer('loadingEntryId')->default(0);
            $table->integer('itemId')->nullable();
            $table->double('rate', 8, 2)->nullable();
            $table->integer('unitId')->nullable();
            $table->integer('qty')->nullable();            
            $table->double('weight', 8, 2)->nullable();       
            $table->double('amount', 8, 2)->nullable();    
            $table->integer('createdById')->nullable();
            $table->integer('companyId')->nullable();
            $table->string('ipAddress')->nullable();   
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
        Schema::dropIfExists('loading_entry_details');
    }
}
