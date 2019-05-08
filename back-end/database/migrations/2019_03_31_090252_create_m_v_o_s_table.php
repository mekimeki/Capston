<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMVOSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mvo_tb', function (Blueprint $table) {
            $table->integer('mvobook_pk')->unsigned();
            $table->integer('vo_pk')->unsigned();
            $table->foreign('mvobook_pk')->references('mvobook_pk')->on('mvobook_tb')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vo_pk')->references('vo_pk')->on('vocabulary_tb')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mvo_tb');
    }
}
