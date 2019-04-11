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
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nickname')->unique();
            $table->string('profile')->nullable();
            $table->char('attandance_st',1)->default('F');
            $table->char('premier_st',1)->default('F');
            $table->timestamp('premier_dt')->nullable();
            $table->integer('point')->default(0);
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
