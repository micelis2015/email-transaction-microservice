<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail', function (Blueprint $table) {
            $table->bigIncrements('mid');
	    $table->string('uid');
	    $table->string('mcid');
            $table->string('created');
            $table->boolean('send_confirmed');
	    $table->integer('send_attempts');
	    $table->timestamps();
        });
	
	Schema::create('mailclient', function (Blueprint $table) {
            $table->bigIncrements('mcid');
	    $table->string('name');
	    $table->string('uri');
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
        Schema::dropIfExists('mail');
	Schema::dropIfExists('mailclient');
    }
}
