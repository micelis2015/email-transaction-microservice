<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
}
