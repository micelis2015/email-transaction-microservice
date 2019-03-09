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
        Schema::create('mailclient', function (Blueprint $table) {
            $table->unsignedBigInteger('mcid', true);
	    $table->string('name');
	    $table->string('uri');
            $table->timestamps();
        });
	
	Schema::create('mailtype', function (Blueprint $table) {
            $table->unsignedBigInteger('mtid', true);
	    $table->string('name');
            $table->timestamps();
        });
	
	Schema::create('mail', function (Blueprint $table) {
            $table->bigIncrements('mid');
	    $table->string('uid');
	    $table->unsignedBigInteger('mtid');
	    $table->unsignedBigInteger('mcid');
	    $table->foreign('mtid')->references('mtid')->on('mailtype');
            $table->foreign('mcid')->references('mcid')->on('mailclient');
	    $table->text('content');
	    $table->boolean('send_confirmed');
	    $table->integer('send_attempts');
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
