<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class q_table extends Model
{
    //


    use \Venturecraft\Revisionable\RevisionableTrait;
    //use Venturecraft\Revisionable\RevisionableTrait;
     public static function boot()
    {
        parent::boot();
    }
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;

    protected $dontKeepRevisionOf = array(
    'q_id',    
    'created_by',
    'last_edited_by',
    );


    protected $primaryKey = 'q_id';
    
}
