<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folower_tb', function (Blueprint $table) {
            $table->integer('m_id')->unsigned();;
            $table->integer('folower_id')->unsigned();;
            $table->foreign('m_id')->references('member_pk')->on('member_tb')->onDelete('cascade');
            $table->foreign('folower_id')->references('member_pk')->on('member_tb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folower_tb');
    }
}
