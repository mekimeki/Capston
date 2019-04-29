<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_tb', function (Blueprint $table) {
            $table->increments('w_pk');
            $table->integer('wbook_pk')->unsigned();
            $table->string('w_nm');
            $table->string('w_chinese')->nullable();
            $table->string('morp');
            $table->integer('w_cnt');
            $table->char('memo_st',1);
            $table->foreign('wbook_pk')->references('wbook_pk')->on('wbook_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('word_tb');
    }
}
