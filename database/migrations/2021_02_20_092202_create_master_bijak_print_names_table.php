<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBijakPrintNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bijak_print_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nameHindi');
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
        Schema::dropIfExists('master_bijak_print_names');
    }
}
