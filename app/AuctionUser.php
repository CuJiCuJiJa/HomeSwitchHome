<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionUser extends Model
{
    protected $table = 'auction_users';

    use SoftDeletes;

    public function auction()
    {
    	return $this->belongsTo('App\Auction');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
