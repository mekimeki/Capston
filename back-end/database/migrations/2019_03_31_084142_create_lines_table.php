<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_tb', function (Blueprint $table) {
            $table->increments('line_pk');
            $table->integer('lbook_id')->unsigned();
            $table->string('line');
            $table->string('explain')->nullable();
            $table->string('pic_add');
            $table->integer('v_id');
            $table->timestamp('start_dt');
            $table->foreign('lbook_id')->references('lbook_pk')->on('lbook_tb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_tb');
    }
}
