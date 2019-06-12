<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'starting_date', 'week', 'year', 'base_price' ];

    public function home()
    {
    	return $this->belongsTo('App\Home');
    }

    public function bids()
    {
    	return $this->hasMany('App\AuctionUser');
    }

}
