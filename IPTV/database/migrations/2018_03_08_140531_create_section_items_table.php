<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section')->unsigned();
            $table->foreign('section')
                  ->references('id')->on('sections')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('name');
            $table->string('poster')->default('default_item.png');
            $table->mediumText('description')->nullable();
            $table->boolean('reservation')->default(False);
            $table->double('longitude', 10, 8)->nullable();
            $table->double('latitude', 10, 8)->nullable();
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
        Schema::dropIfExists('section_items');
    }
}
