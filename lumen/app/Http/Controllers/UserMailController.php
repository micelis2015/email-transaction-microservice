<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Jobs\ProcessUserMail;
use App\UserMail;

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
	
	//Don't bother if there isnt an email address.
	if (empty($request->input('mail_to'))){
	    \Log::info('No emails found');
	    return response()->json(['error' => 'No email supplied']);
	}

	//split emails into seperate records
	if (empty($emails = explode(',', $request->input('mail_to')))){
	    $emails = array($request->input('mail_to'));
	}
	
	foreach ($emails as $key => $mailto){	
		//Insert record in the DB, or retrieve existing to update
		if ($mid != null){
		   $existing =  app('db')->table('mail')->where('id', '=', $mid)->get();
		}
		else{
		    $existing = app('db')->table('mail')->where('uid', '=', $request->input('uid'))->where('mail_to', '=', trim($mailto))->where('content', '=', $request->input('content'))->get();
		}

		\Log::info("processing mail" . var_export($request, true));

		if($existing->count() > 0) {
		   $result[$key] = $existing;
		}
		else{
		    $result[$key] = UserMail::create([
			'uid' => $request->input('uid'),
			'mtid' => $request->input('mtid'),
			'mpid' => 1,
			'mail_to' => trim($mailto),
			'content' => $request->input('content'),
			'subject' => $request->input('subject'),
			'msid' => 1,
			'send_attempts' => 0
		    ]);

		    //queue mail for sending	
		    dispatch(new ProcessUserMail($result[$key]));

		}
	}

	return response()->json(['result' => $result]);
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
	    $result = app('db')->table('mail')->where('uid', '=', $uid)->where('id', '=', $mid)->delete();
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
	    $query = app('db')->table('mail')->where('uid', '=', $uid)->where('mail.id', '=', $mid)->select();
	}
	else{
	    $query = app('db')->table('mail')->where('uid', '=', $uid)->select();
	}
	
	$query->join('mailprovider', 'mail.mpid', '=', 'mailprovider.id');
	$query->join('mailtype', 'mail.mtid', '=', 'mailtype.id');
	$query->join('mailstatus', 'mail.msid', '=', 'mailstatus.id');
	
	try {
	    $results = $query->addSelect('mail.id as mid')->get();
	}
	catch (Illuminate\Database\QueryException $e){
	    return response()->json(['error' => $e]);
	}
	
	return response()->json(['results' => $results]);
    }

    //
}
