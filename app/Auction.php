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
    	return $this->belongsTo('App\Home')->withTrashed();
    }

    public function bids()
    {
    	return $this->hasMany('App\AuctionUser');
    }

    public function scopeBiddersByLatest()
    {
        return $this->bids()->where('value', '>=', $this->base_price)->latest()->get()->unique('user_id');
    }
}
