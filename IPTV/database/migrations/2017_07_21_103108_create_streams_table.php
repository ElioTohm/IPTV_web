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
            $table->increments('id')->unsigned();
            $table->string('vid_stream');
            $table->string('sub_stream')->nullable();
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
        Schema::dropIfExists('streams_types');
        Schema::dropIfExists('streams');

    }
}
