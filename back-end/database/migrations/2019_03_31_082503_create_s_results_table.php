<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sresult_tb', function (Blueprint $table) {
            $table->increments('sresult_pk');
            $table->integer('m_id')->unsigned();
            $table->integer('v_id');
            $table->integer('100ls_score');
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
        Schema::dropIfExists('sresult_tb');
    }
}
