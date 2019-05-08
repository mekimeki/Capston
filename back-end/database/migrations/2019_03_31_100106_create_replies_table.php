<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_tb', function (Blueprint $table) {
            $table->increments('reply_pk');
            $table->integer('video_id')->unsigned();
            $table->integer('replier_id');
            $table->string('reply');
            $table->string('date');
            $table->string('parent')->nullable();
            $table->foreign('video_id')->references('video_pk')->on('video_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_tb');
    }
}
