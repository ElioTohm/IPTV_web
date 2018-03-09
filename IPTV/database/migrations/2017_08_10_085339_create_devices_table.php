<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->integer('assigned_to')->default(0);
            $table->integer('registered')->default(0);
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')
                ->references('id')
                ->on('oauth_clients')
                ->onDelete('cascade');
            $table->integer('room');
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
        Schema::dropIfExists('devices');
    }
}
