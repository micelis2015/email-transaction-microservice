<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Jobs\ProcessUserMail;

class UserMailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
        
     /**
     * Create or update the UserMail for the given ID.
     *
     * @param  int  $uid
     * @param  int  $mid
     * @return Response
     */
    public function put(Request $request, $uid, $mid = null) {
	
	//Insert record in the DB, or retrieve existing to update
	if ($mid != null){
	   $existing =  app('db')->table('mail')->where('mid', '=', $mid)->get();
	}
	else{
	    $existing = app('db')->table('mail')->where('mail_to', '=', $request['mail_to'])->where('content', '=', $request['content'])->get();
	}
	
	if($existing){
	    $result = $existing;
	}
	else{
	    $result = app('db')->table('mail')->insertGetId([
		'uid' => $uid,
		'mtid' => $request->input('mtid'),
		'mpid' => 1,
		'mail_to' => $request->input('mail_to'),
		'content' => $request->input('content'),
		'send_confirmed' => 0,
		'send_attempts' => 0
	    ])->get();
	}
	
	//queue mail for sending	
	#$mail = new \stdClass();	
	#$mail->mid = $result->input('mid');
		
	#ProcessUserMail::dispatch($mail);
	return response()->json(['result' => $result, 'request' => $request->input()]);
    }
    
     /**
     * Delete UserMail for a particular user and optional mail id.
     *
     * @param  int  $uid
     * @param  int  $mid 
     * @return Response
     */
    public function delete($uid, $mid = null) {
	
	if ($mid != null){
	    $result = app('db')->table('mail')->where('uid', '=', $uid)->where('mid', '=', $mid)->delete();
	}
	else {
	    $result = app('db')->table('mail')->where('uid', '=', $uid)->delete();
	}
	
	return response()->json(['results' => $result]);
	
    }
    
     /**
     * Get UserMail for a particular user and optional mail id.
     *
     * @param  int  $uid
     * @param  int  $mid 
     * @return Response
     */
    public function get ($uid, $mid = null) {
	
	if ($mid != null){
	    $query = app('db')->table('mail')->where('uid', '=', $uid)->where('mid', '=', $mid);
	}
	else{
	    $query = app('db')->table('mail')->where('uid', '=', $uid)->select();
	}
	
	$query->join('mailprovider', 'mail.mpid', '=', 'mailprovider.mpid');
	$query->join('mailtype', 'mail.mtid', '=', 'mailtype.mtid');
	
	try {
	    $results = $query->get();
	}
	catch (Illuminate\Database\QueryException $e){
	    return response()->json(['error' => $e]);
	}
	
	return response()->json(['results' => $results]);
    }

    //
}
