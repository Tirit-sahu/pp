<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nameHindi')->nullable();
            $table->string('logo')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('address')->nullable();
            $table->string('addressHindi')->nullable();
            $table->string('slog')->nullable();
            $table->string('slogHindi')->nullable();
            $table->string('emailId')->nullable();
            $table->string('termCondition')->nullable();
            $table->string('tinNumber')->nullable();
            $table->string('gstNumber')->nullable();
            $table->string('bankName')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('ifscCode')->nullable();
            $table->integer('stateId')->nullable();                 
            $table->integer('openingBalance')->nullable();
            $table->date('openingBalanceDate')->nullable();
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
        Schema::dropIfExists('master_company_settings');
    }
}
