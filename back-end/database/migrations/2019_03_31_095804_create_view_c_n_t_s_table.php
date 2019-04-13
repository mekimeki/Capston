<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCNTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_cnt_tb', function (Blueprint $table) {
            $table->integer('video_pk')->unsigned();
            $table->integer('m_id')->unsigned();
            $table->foreign('video_pk')->references('video_pk')->on('video_tb');
            $table->foreign('m_id')->references('m_id')->on('video_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_cnt_tb');
    }
}
