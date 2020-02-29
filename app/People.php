<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected  $table='people';
    protected  $primaryKey='p_id';
    public  $timestamps=false;
    protected $guarded=[];
}
