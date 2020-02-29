<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table='article';
    protected $primaryKey='a_id';
    protected $guarded=[];
    public $timestamps=false;
}
