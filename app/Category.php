<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table='category';
    protected $primaryKey='c_id';
    public $timestamps=false;
    protected $guarded=[];
}
