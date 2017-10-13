<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_types', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('name');
            $table->string('stream')->unique();
            $table->integer('stream_type')->unsigned();
            $table->foreign('stream_type')
                    ->references('id')->on('stream_types');
            $table->string('thumbnail')->default("DefaultThumbnail.png");;
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('channel_genre', function (Blueprint $table) {
            $table->integer('channel')->unsigned();
            $table->integer('genre')->unsigned();
            $table->primary(['channel', 'genre']);
            $table->foreign('channel')
                  ->references('id')->on('channels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('genre')
                  ->references('id')->on('genres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
        Schema::dropIfExists('channel_genre');
        Schema::dropIfExists('channels');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('stream_types');
    }
}
