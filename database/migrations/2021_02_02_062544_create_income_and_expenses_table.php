<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeAndExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_and_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('Type');
            $table->double('Amount',8,2);
            $table->string('Remark');
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
        Schema::dropIfExists('income_and_expenses');
    }
}
