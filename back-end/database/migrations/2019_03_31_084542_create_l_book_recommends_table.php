<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBookRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lbook_recommend_tb', function (Blueprint $table) {
            $table->integer('lbook_id')->unsigned();
            $table->integer('m_id')->unsigned();
            $table->char('lbook_rec',1)->default('F');
            $table->foreign('lbook_id')->references('lbook_pk')->on('lbook_tb')->onDelete('cascade');
            $table->foreign('m_id')->references('m_id')->on('lbook_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lbook_recommend_tb');
    }
}
