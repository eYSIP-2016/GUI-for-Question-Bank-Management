<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class q_table extends Model implements Revisionable
{
    //
    use RevisionableTrait;


    protected $revisionable=[
    'category',
    'description_id',
    'diagram_id',
    'exp_id',
    'code_id',
    'difficulty',
    'time'
    ];


    /**use \Venturecraft\Revisionable\RevisionableTrait;
    //use Venturecraft\Revisionable\RevisionableTrait;
     public static function boot()
    {
        parent::boot();
    }
    **/
    use SoftDeletes;
    protected $dates = ['deleted_at'];
   // protected $revisionEnabled = true;
    //protected $revisionCreationsEnabled = true;

    /**protected $dontKeepRevisionOf = array(
    'q_id',    
    'created_by',
    'last_edited_by',
    );**/
    protected $revisionPresenter = 'App\Presenters\q_table';

    protected $fillable = [
        ''
    ];

    protected $primaryKey = 'q_id';
    
}
