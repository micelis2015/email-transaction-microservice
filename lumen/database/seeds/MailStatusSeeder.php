<?php

use Illuminate\Database\Seeder;

class MailStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('mailstatus')->insert([
            'id' => 1,
            'status' => 'Send'
        ]);
	
	app('db')->table('mailstatus')->insert([
            'id' => 2,
            'status' => 'Queued'
        ]);
	
	app('db')->table('mailstatus')->insert([
            'id' => 99,
            'status' => 'Bounced'
        ]);
    }
}
