<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadingEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loading_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('Loading Date')->nullable();
            $table->integer('loaderId')->nullable();
            $table->string('vehicleNumber')->nullable();
            $table->integer('farmerId')->nullable();
            $table->double('motorBhada', 8, 2)->nullable();
            $table->double('advance', 8, 2)->nullable();
            $table->double('driverInaam', 8, 2)->nullable();
            $table->double('totalBhada', 8, 2)->nullable();
            $table->double('totalAmount', 8, 2)->nullable();
            $table->string('driverMobile')->nullable();
            $table->string('narration')->nullable();
            $table->double('netAmount', 8, 2)->nullable();            
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
        Schema::dropIfExists('loading_entries');
    }
}
