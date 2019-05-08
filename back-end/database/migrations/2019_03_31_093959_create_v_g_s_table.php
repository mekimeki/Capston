<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVGSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vg_tb', function (Blueprint $table) {
            $table->increments('video_pk');
            $table->integer('gidiom_pk')->unsigned();
            $table->timestamp('start_dt');
            $table->double('start_time',8,3);
            $table->double('end_time',8,3);
            $table->foreign('video_pk')->references('video_pk')->on('video_tb');
            $table->foreign('gidiom_pk')->references('vo_pk')->on('vocabulary_tb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vg_tb');
    }
}
