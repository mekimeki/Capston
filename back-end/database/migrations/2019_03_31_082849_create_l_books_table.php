<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lbook_tb', function (Blueprint $table) {
            $table->increments('lbook_pk');
            $table->integer('m_id')->unsigned();
            $table->string('lbook_tt');
            $table->string('lbook_lan');
            $table->foreign('m_id')->references('member_pk')->on('member_tb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lbook_tb');
    }
}
