<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAddtionalExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_addtional_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nameHindi')->nullable();
            $table->string('type')->nullable()->comment('PERCENTAGE, RUPEES');
            $table->string('process')->nullable()->comment('ADD, SUBTRACT');
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
        Schema::dropIfExists('master_addtional_expenses');
    }
}
