<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Jobs\ProcessUserMail;

class UserMail extends Model
{
   
    protected $table = 'mail';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'content', 'subject', 'mail_to', 'mpid', 'mtid', 'msid', 'send_attempts'
    ];
    
    /**
     * Get UserMail for a particular user and optional mail id.
     *
     * @param  int $uid
     * @param  int $mid 
     * @return DataBaseQuery
     */
    public static function getUserMail($uid, $mid = null)
    {
    
        if ($mid != null) {
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
            return ['error' => $e];
        }
    
        return $results;
    }
    
     /**
      * Delete UserMail for a particular user and optional mail id.
      *
      * @param  int $uid
      * @param  int $mid 
      * @return DataBaseQuery
      */
    public static function deleteUserMail($uid, $mid = null)
    {
    
        if ($mid != null) {
            $result = app('db')->table('mail')->where('uid', '=', $uid)->where('id', '=', $mid)->delete();
        }
        else {
            $result = app('db')->table('mail')->where('uid', '=', $uid)->delete();
        }
    
        return $result;
    
    }
    
        /**
         * Create or update the UserMail for the given ID.
         *
         * @param  array input
         * @return UserMail
         */
    public static function putUserMail(array $input)
    {
    
        \Log::info(json_encode($input));
        //Don't bother if there isnt an email address.
        if (empty($input['mail_to'])) {
            \Log::info('No emails found');
            return ['error' => 'No email supplied'];
        }

        //split emails into seperate records
        if (empty($emails = explode(',', $input['mail_to']))) {
            $emails = array($input['mail_to']);
        }
    
        foreach ($emails as $key => $mailto){    
            //Insert record in the DB, or retrieve existing to update
            if (array_key_exists('mid', $input)) {
                $existing =  app('db')->table('mail')->where('id', '=', $input['mid'])->get();
            }
            else{
                $existing = app('db')->table('mail')->where('uid', '=', $input['uid'])->where('mail_to', '=', trim($mailto))->where('content', '=', $input['content'])->get();
            }

            \Log::info("processing mail" . json_encode($input));

            if($existing->count() > 0) {
                $result[$key] = $existing;
                \Log::info('Existing email matching inputs found, do nothing');
            }
            else{
                $result[$key] = UserMail::create(
                    [
                    'uid' => $input['uid'],
                    'mtid' => $input['mtid'],
                    'mpid' => 1,
                    'mail_to' => trim($mailto),
                    'content' => $input['content'],
                    'subject' => $input['subject'],
                    'msid' => 1,
                    'send_attempts' => 0
                      ]
                );

                //queue mail for sending    
                dispatch(new ProcessUserMail($result[$key]));

            }
        }

        return $result;
    }
    
}
