<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocas', function (Blueprint $table) {
            $table->increments('w_id');
            $table->unsignedInteger('b_id');
            $table->foreign('b_id')->references('b_id')->on('books')->onUpdate('cascade')->onDelete('cascade');
            $table->string('word');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vocas');
    }
}
