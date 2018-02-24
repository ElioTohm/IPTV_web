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

        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('number')->unique();
            $table->string('name');
            $table->string('thumbnail')->default('DefaultThumbnail.png');
            $table->integer('price')->default(0);
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
    }
}
