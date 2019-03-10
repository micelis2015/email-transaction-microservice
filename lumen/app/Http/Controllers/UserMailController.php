<?php

namespace App\Http\Controllers;

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
    public function put($uid, $mid = null) {
	
	return response()->json(['name' => 'Abigail', 'state' => 'CA']);
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
	
	$query->join('mailclient', 'mail.mcid', '=', 'mailclient.mcid');
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
