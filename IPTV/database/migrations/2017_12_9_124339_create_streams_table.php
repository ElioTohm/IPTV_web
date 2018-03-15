<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams_types', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('streams', function (Blueprint $table){
            $table->increments('id');
            $table->string('vid_stream');
            $table->string('sub_stream')->nullable();
            $table->integer('channel')->unsigned()->nullable();
            $table->foreign('channel')->references('number')->on('channels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('movie')->unsigned()->nullable();
            $table->foreign('movie')->references('id')->on('movies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('streams_types'); 
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
        //
        Schema::dropIfExists('streams');
        Schema::dropIfExists('streams_types');
    }
}
