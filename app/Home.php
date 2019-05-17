<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['location', 'descrip'];

}