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
        Schema::create('mailprovider', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
	    $table->string('name');
	    $table->string('class');
        });
	
	Schema::create('mailstatus', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
	    $table->string('status');
        });
	
	
	Schema::create('mailtype', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
	    $table->string('type');
        });
	
	Schema::create('mail', function (Blueprint $table) {
            $table->bigIncrements('id');
	    $table->string('uid');
	    $table->unsignedBigInteger('mtid');
	    $table->unsignedBigInteger('mpid');
	    $table->string('mail_to');
	    $table->text('subject');
	    $table->text('content');
	    $table->unsignedBigInteger('msid');
	    $table->integer('send_attempts');
	    $table->timestamps();
	    $table->foreign('mtid')->references('id')->on('mailtype');
            $table->foreign('mpid')->references('id')->on('mailprovider');  
	    $table->foreign('msid')->references('id')->on('mailstatus');  
        });
	
	Schema::create('jobs', function (Blueprint $table) {
	    $table->bigIncrements('id');
	    $table->string('queue');
	    $table->longText('payload');
	    $table->tinyInteger('attempts')->unsigned();
	    $table->unsignedInteger('reserved_at')->nullable();
	    $table->unsignedInteger('available_at');
	    $table->unsignedInteger('created_at');
	    $table->index(['queue', 'reserved_at']);
	});

	Schema::create('failed_jobs', function (Blueprint $table) {
	    $table->increments('id');
	    $table->text('connection');
	    $table->text('queue');
	    $table->longText('payload');
	    $table->longText('exception');
	    $table->timestamp('failed_at')->useCurrent();
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
	Schema::dropIfExists('mailtype');
	Schema::dropIfExists('jobs');
    }
}
