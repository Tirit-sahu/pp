<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherIncomeAndExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_income_and_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nameHindi');
            $table->string('type');
            $table->integer('createdById');
            $table->integer('companyId');
            $table->string('ipAddress');
            $table->string('session');
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
        Schema::dropIfExists('other_income_and_expenses');
    }
}
