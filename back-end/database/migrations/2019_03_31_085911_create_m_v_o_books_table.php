<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMVOBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mvobook_tb', function (Blueprint $table) {
            $table->increments('mvobook_pk');
            $table->integer('member_pk')->unsigned();
            $table->string('title');
            $table->foreign('member_pk')->references('member_pk')->on('member_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mvobook_tb');
    }
}
