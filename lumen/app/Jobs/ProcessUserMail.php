<?php

namespace App\Jobs;

use App\UserMail;

class ProcessUserMail extends Job
{
    
    protected $mail;

    /**
     * Create a new job instance.
     *
     * @param  UserMail  $mail
     * @return void
     */
    public function __construct(UserMail $mail)
    {
        $this->mail = $mail;
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
	SendMail($this->mail);
	
	$mail->mpid = $mail->mpid+1;
	
	//if that fails, send mail to fallback option(s)
	SendMail($this->mail);
    }
}

function SendMail(UserMail $mail){
    
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("root", "Root User");
    $email->setSubject("Email tes");
    $email->addTo($mail->mail_to, $mail->mail_to);
    $email->addContent(
	"text/html", $mail->content
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
