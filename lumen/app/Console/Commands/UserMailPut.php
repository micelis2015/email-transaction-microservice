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
 * Class UserMailPost
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class UserMailPut extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "usermail:put "
	    . "{uid : User ID} "
	    . "{mtid : Mail Type ID - 1 for HTML, 2 for Text and 3 for MD} "
	    . "{mail_to : where to send email to, multiples allowed if seperated by ,} "
	    . "{content :  email content appropriate to the type chosen} "
	    . "{subject : subject line text} "
	    . "{mid? : [optional] mail id of existing mail}";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Add email for a user";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if (!$this->argument('mid')) {
		$this->info(json_encode(UserMail::putUserMail($this->arguments())));
	    }
	    else {
		$this->info(json_encode(UserMail::putUserMail($this->arguments())));
	    }	   
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}