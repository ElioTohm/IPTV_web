<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->integer('room');
            $table->string('welcome_message')->default('Welcome');
            $table->string('welcome_image')->default('Defaultimage.png');
            $table->bigInteger('credit');
            $table->bigInteger('debit')->default(0);
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('purchasable_id');
            $table->string('purchasable_type');
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
        Schema::dropIfExists('clients');
        Schema::dropIfExists('purchases');
    }
}
