<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class tags extends Model
{   
	//use \Venturecraft\Revisionable\RevisionableTrait;
   // use \Venturecraft\Revisionable\RevisionableTrait; 
   /**     public static function boot()
    {
        parent::boot();
    }

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $revisionEnabled = true;**/

	protected $guarded = [];
    protected $fillable = [];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    
}
