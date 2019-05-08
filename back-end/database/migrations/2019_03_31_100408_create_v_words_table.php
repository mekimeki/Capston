<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vword_tb', function (Blueprint $table) {
            $table->increments('vw_pk');
            $table->integer('v_id')->unsigned();
            $table->string('vw_nm');
            $table->string('w_exp');
            //$table->timestamp('start_dt')->nullable();
            $table->integer('origin_id')->nullable();
            $table->double('start_time',8,3);
            $table->double('end_time',8,3);
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
        Schema::dropIfExists('vword_tb');
    }
}
