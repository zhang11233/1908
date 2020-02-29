<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logins extends Model
{
    protected $table='users';
    protected $primaryKey='users_id';
    public $timestamps=false;
    protected $guarded=[];
}
