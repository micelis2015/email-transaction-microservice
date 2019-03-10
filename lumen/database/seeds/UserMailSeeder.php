<?php

use Illuminate\Support\Str;
use Illuminate\Support\Integer;
use Illuminate\Database\Seeder;

class UserMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('mail')->insert([
            'mid' => 1,
	    'uid' => 1,
	    'mtid' => 1,
	    'mpid' => 1,
	    'mail_to' => Str::random(10).'@yahoo.com',
	    'content' => 'This is content, can be <a>html</a>',
	    'send_confirmed' => 0,
	    'send_attempts' => rand(0,100)
        ]);
	
	app('db')->table('mail')->insert([
            'mid' => 2,
	    'uid' => 1,
	    'mtid' => 1,
	    'mpid' => 2,
	    'mail_to' => Str::random(10).'@yahoo.com',
	    'content' => 'Another mail',
	    'send_confirmed' => 1,
	    'send_attempts' => rand(0,10)
        ]);
    }
}
