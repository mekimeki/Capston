<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_tb', function (Blueprint $table) {
            $table->increments('video_pk');
            $table->integer('m_id')->unsigned();
            $table->string('v_tt');
            $table->text('explain')->nullable();
            $table->string('v_add');
            $table->string('sub_add');
            $table->string('trans_sub_add')->nullable();
            $table->date('d_date')->nullable();
            $table->foreign('m_id')->references('member_pk')->on('member_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_tb');
    }
}
