<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\UserMail;

class UserMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMail::create([
            'id' => 1,
	    'uid' => 1,
	    'mtid' => 1,
	    'mpid' => 1,
	    'mail_to' => Str::random(10).'@yahoo.com',
	    'subject' => 'Test Email',
	    'content' => 'This is content, can be <a>html</a>',
	    'msid' => 2,
	    'send_attempts' => rand(0,100)
        ]);
	
	UserMail::create([
            'id' => 2,
	    'uid' => 1,
	    'mtid' => 1,
	    'mpid' => 2,
	    'subject' => 'Yet Another Email',
	    'mail_to' => Str::random(10).'@yahoo.com',
	    'content' => 'Another mail',
	    'msid' => 99,
	    'send_attempts' => rand(0,10)
        ]);
    }
}
