<?php

namespace App\Jobs;

use App\UserMail;
use Illuminate\Queue\InteractsWithQueue;

class ProcessUserMail extends Job
{
    use InteractsWithQueue;
    
    protected $mail;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param  UserMail  $mail
     * @return void
     */
    public function __construct(UserMail $mail)
    {
        $this->mail = $mail;
	$this->tries = app('db')->table('mailprovider')->count();
	
	\Log::info('Max tries set to ' . $this->tries);
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
	\Log::info('Start job with mail:'. $this->mail);
	//Send email to Sendgrid
	
	$provider = app('db')->table('mailprovider')->where('id', '=', $this->mail->mpid)->get();
	
	\Log::info("Send email using provider " . $provider->first()->name);
	
	$MailClass = $provider->first()->class;
	
	if ($this->$MailClass()){
	    \Log::info("Email send, remove job");#
	    $this->delete();
	}
	
	$this->mail->mpid++;
	
    }

    function SendGridMail(){
	
	$mailtype = app('db')->table('mailtype')->where('id', '=', $this->mail->mtid)->get();
	
	\Log::info('Type of mail : ' . $mailtype);

	$email = new \SendGrid\Mail\Mail(); 
	$email->setFrom(env('EMAIL_FROM'), "DONOTREPLY");
	$email->setSubject($this->mail->subject);
	$email->addTo($this->mail->mail_to, $this->mail->mail_to);
	$email->addContent(
	    $mailtype->first()->type, $this->mail->content
	);
	$sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
	try {
	    $response = $sendgrid->send($email);
	    print $response->statusCode() . "\n";
	    print_r($response->headers());
	    print $response->body() . "\n";
	} catch (Exception $e) {
	    echo 'Caught exception: '. $e->getMessage() ."\n";
	}
	 return true;

    }
    
    function MailJetMail(){

	

    }

}