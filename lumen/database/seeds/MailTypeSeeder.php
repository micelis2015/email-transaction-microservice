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
            'mtid' => 1,
            'name' => 'html'
        ]);
    }
}
