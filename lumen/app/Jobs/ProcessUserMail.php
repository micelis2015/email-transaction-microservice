<?php

namespace App\Jobs;

use App\UserMail;
use Illuminate\Queue\InteractsWithQueue;
use \Mailjet\Resources;

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
	
	if (!$this->SendMail()) {
	    $this->mail->msid = 99;
	}
	
	$this->mail->save();
	
    }
    
    function SendMail() {
	$nomailproviders = app('db')->table('mailprovider')->count();
	
	$MailClass = $this->getMailClass();
	
	if ($this->$MailClass()){
	    \Log::info("Email send, update record and remove job");#
	    $this->mail->msid = 2;
	    $this->mail->send_attempts++;
	    $this->delete();
	    return true;
	}
	else if ($this->mail->mpid < $nomailproviders) {
	   \Log::info("Email not send, update provider and try again");
	   $this->mail->mpid++;
	   $this->mail->send_attempts++;
	   $this->SendMail();
	}
	
	\Log::info("Email not send, no providers left to try");
	
	return false;
	
    }
    
    function getMailClass(){
	
	$provider = app('db')->table('mailprovider')->where('id', '=', $this->mail->mpid)->get();
	
	\Log::info("Send email using provider " . $provider->first()->name);
	
	return $provider->first()->class;
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
	
	if ($response->statusCode() != 202) {
	    \Log::info('Email not sent, error code:' . $response->statusCode());
	    return false;
	}
	
	return true;

    }
    
    function MailJetMail(){
	
	\Log::info("Sending MailJet email");
	
	$mailtype = app('db')->table('mailtype')->where('id', '=', $this->mail->mtid)->get();	

	$mj = new \Mailjet\Client(env('MAILJET_API_KEY'), env('MAILJET_API_SECRET'),true,['version' => 'v3.1']);
	$body = [
	    'Messages' => [
		[
		    'From' => [
			'Email' => env('EMAIL_FROM'),
			'Name' => "DONOTREPLY"
		    ],
		    'To' => [
			[
			    'Email' => $this->mail->mail_to,
			    'Name' => $this->mail->mail_to
			]
		    ],
		    'Subject' => $this->mail->subject,
		    'HTMLPart' => $this->mail->content
		]
	    ]
	];
	$response = $mj->post(Resources::$Email, ['body' => $body]);
	
	\Log::info($response->getData());
	
	return $response->success();

    }

}