<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votest_result_tb', function (Blueprint $table) {
            $table->increments('votest_result_pk');
            $table->integer('m_id')->unsigned();
            $table->timestamp('test_dt');
            $table->string('test_add');
            $table->integer('test_score');
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
        Schema::dropIfExists('votest_result_tb');
    }
}
