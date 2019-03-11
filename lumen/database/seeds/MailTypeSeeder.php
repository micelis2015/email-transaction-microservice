<?php

use Illuminate\Database\Seeder;

class MailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('mailtype')->insert([
            'id' => 1,
            'type' => 'text/html'
        ]);
	
	app('db')->table('mailtype')->insert([
            'id' => 2,
            'type' => 'text/plain'
        ]);
	
	app('db')->table('mailtype')->insert([
            'id' => 3,
            'type' => 'text/markdown'
        ]);
    }
}
