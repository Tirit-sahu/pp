<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCarretReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_carret_receives', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('customerId');  
            $table->integer('unitId'); 
            $table->integer('qty');               
            $table->string('narration')->nullable();
            $table->integer('isComplete')->default(0);
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
        Schema::dropIfExists('customer_carret_receives');
    }
}
