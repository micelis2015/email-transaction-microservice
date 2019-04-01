<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
      * @param  Request $request
      * @return Response
      */
    public function put(Request $request)
    {
    
        return response()->json(['results' => UserMail::putUserMail($request->input())]); 
    
    }
    
     /**
      * Delete UserMail for a particular user and optional mail id.
      *
      * @param  int $uid
      * @param  int $mid 
      * @return Response
      */
    public function delete($uid, $mid = null)
    {
    
        return response()->json(['results' => UserMail::deleteUserMail($uid, $mid)]); 
    
    }
    
     /**
      * Get UserMail for a particular user and optional mail id.
      *
      * @param  int $uid
      * @param  int $mid 
      * @return Response
      */
    public function get($uid, $mid = null)
    {
    
        return response()->json(['results' => UserMail::getUserMail($uid, $mid)]); 
    }

    //
}
