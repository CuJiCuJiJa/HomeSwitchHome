<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomeUser extends Model
{
    protected $table = 'home_users';

    use SoftDeletes;

    public function home()
    {
        return $this->belongsTo('App\Home');
    }
}
