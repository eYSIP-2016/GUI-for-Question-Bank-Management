<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{   

       
    /**
     * The attributes that are mass assignable.
     *define rules here
     * @var array
     */
    protected $fillable = [
        'name','username','email', 'password','version'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function questions()
    {
        return $this->hasMany('App\q_table','created_by');
    }
}
