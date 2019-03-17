<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\UserMail;
use Exception;
use Illuminate\Console\Command;



/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UserMailGet extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "usermail:get "
	    . "{uid : User ID} "
	    . "{mid? : [optional] mail id of existing mail}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get all mail for a user";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
	    if (!$this->arguments('mid')) {
		$this->info(json_encode(UserMail::getUserMail($this->argument('uid'))));
	    }
	    else {
		$this->info(json_encode(UserMail::getUserMail($this->argument('uid'), $this->argument('mid'))));
	    }    
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}