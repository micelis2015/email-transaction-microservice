<?php

use Illuminate\Database\Seeder;

class MailProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('mailprovider')->insert([
            'id' => 1,
	    'name' => "SendGrid",
	    'uri' => 'https://api.sendgrid.com'
        ]);
	
	app('db')->table('mailprovider')->insert([
            'id' => 2,
	    'name' => "MailJet",
	    'uri' => 'https://api.mailjet.com'
        ]);
    }
}
