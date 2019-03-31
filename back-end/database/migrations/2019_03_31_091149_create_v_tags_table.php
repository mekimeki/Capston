<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vtag_tb', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->integer('video_id')->unsigned();
            $table->foreign('tag_id')->references('tag_pk')->on('tag_tb');
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
        Schema::dropIfExists('vtag_tb');
    }
}
