<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_tb', function (Blueprint $table) {
            $table->increments('member_pk');
            $table->string('email');
            $table->string('pw');
            $table->string('nickname');
            $table->string('profile')->nullable();
            $table->char('attandance_st',1);
            $table->char('premier_st',1);
            $table->timestamp('premier_dt')->nullable();
            $table->integer('point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_tb');
    }
}
