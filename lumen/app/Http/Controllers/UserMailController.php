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
	
	return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }
    
     /**
     * Get UserMail for a particular user and optional mail id.
     *
     * @param  int  $uid
     * @param  int  $mid 
     * @return Response
     */
    public function get ($uid, $mid = null) {
	
	$result = app('db')->select("SELECT * FROM mail where uid = $uid");
	
	return response()->json(['result' => $result]);
    }

    //
}
