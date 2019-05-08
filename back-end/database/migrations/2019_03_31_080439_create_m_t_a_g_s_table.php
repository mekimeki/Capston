<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMTAGSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtag_tb', function (Blueprint $table) {
            $table->increments('tag_id');
            $table->integer('member_id')->unsigned();
            $table->foreign('tag_id')->references('tag_pk')->on('tag_tb')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id')->references('member_pk')->on('member_tb')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mtag_tb');
    }
}
