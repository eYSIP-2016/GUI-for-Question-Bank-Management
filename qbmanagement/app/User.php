<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class User extends Authenticatable implements Revisionable
{   
    use RevisionableTrait;

    
    //use \Venturecraft\Revisionable\RevisionableTrait;
    //use Venturecraft\Revisionable\RevisionableTrait;
    /** public static function boot()
    {
        parent::boot();
    }**/
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    //protected $revisionEnabled = true;
    //protected $revisionCreationsEnabled = true;

    

    /**
     * The attributes that are mass assignable.
     *define rules here
     * @var array
     */
    protected $revisionPresenter = 'App\Presenters\User';

    protected $fillable = [
        'name','username','email', 'password','version'
    ];
    

    protected $revisionable=[
    'name',
    'username',
    'email',
    'version'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tags()
    {
        return $this->hasOne('App\tags','id','version');
    }
}
