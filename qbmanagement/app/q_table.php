<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class q_table extends Model implements Revisionable
{

    use RevisionableTrait;         

    protected $revisionable=[
    'category',
    'description_id',
    'diagram_id',
    'exp_id',
    'code_id',/**
    'options',
    'tag_revision',  **/
    'difficulty',
    'time'
    //,last_edited_by  
    ];

    //Using Revisionable Presenter for presenting the label  { Its optional}
    protected $revisionPresenter = 'App\Presenters\q_table';

    
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];


    

    protected $fillable = [
        'category',
        'description_id',
        'tag_revision',
        'difficulty',
        'time',
        'version',
        'created_by'
    ];

    protected $primaryKey = 'q_id';



    //**************************//Relations//**********************************//

    /***For Description***/

    public function description()
    {
        return $this->hasOne('App\q_description','description_id','description_id');
    }

    /***For Category***/
    public function category()
    {
        return $this->hasOne('App\category','key','category');
    }
    
}
