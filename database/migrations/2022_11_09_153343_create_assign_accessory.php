<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignAccessory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_accessories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('accessory_id')->unsigned();
            $table->integer('authority_id')->unsigned();
            $table->string('authority_name');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('accessory_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('authority_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date_of_assignment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assign_accessories');
    }
}


