<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{	
    use SoftDeletes;
    
    protected $fillable = ['location', 'descrip'];

    public function hotsales()
    {
    	return $this->hasMany('App\Hotsales');
    }

    public function scopeHasActiveHotsales()
    {
    	return $query($this->hotsales())->where('active', true);
    }

}