<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wbook_tb', function (Blueprint $table) {
            $table->increments('wbook_pk');
            $table->integer('m_id')->unsigned();
            $table->string('wbook_tt');
            $table->string('wbook_lan');
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
        Schema::dropIfExists('wbook_tb');
    }
}
