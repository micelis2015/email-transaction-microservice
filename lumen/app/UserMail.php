<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'mail_to', 'mpid', 'mtid'
    ];
    
}
