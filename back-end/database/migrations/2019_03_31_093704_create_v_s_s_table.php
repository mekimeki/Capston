<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_tb', function (Blueprint $table) {
            $table->increments('vs_pk');
            $table->integer('v_id')->unsigned();
            $table->timestamp('vstart_dt');
            $table->foreign('v_id')->references('video_pk')->on('video_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vs_tb');
    }
}
