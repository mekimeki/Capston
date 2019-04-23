<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWBookRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wbook_recommend_tb', function (Blueprint $table) {
            $table->integer('wbook_id')->unsigned();
            $table->integer('m_id')->unsigned();
            $table->char('wbook_rec',1)->default('F');
            $table->foreign('wbook_id')->references('wbook_pk')->on('wbook_tb');
            $table->foreign('m_id')->references('m_id')->on('wbook_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wbook_recommend_tb');
    }
}
