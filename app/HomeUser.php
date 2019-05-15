<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomeUser extends Model
{
    protected $table = 'home_user';

    use SoftDeletes;
}