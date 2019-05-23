<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuctionUser extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'value' ];

    public function auction()
    {
    	return $this->belongsTo('App\Auction');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
