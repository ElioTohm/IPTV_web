<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // movies table
        Schema::create('movies', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('stream')->unique();
            $table->string('poster')->default("DefaultThumbnail.png");;
            $table->timestamps();
        });

        Schema::create('movies_genre', function (Blueprint $table) {
            $table->integer('movie')->unsigned();
            $table->integer('genre')->unsigned();
            $table->primary(['movie', 'genre']);
            $table->foreign('movie')
                  ->references('id')->on('movies')
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
        //
        Schema::dropIfExists('movies_genre');
        Schema::dropIfExists('movies');
    }
}
