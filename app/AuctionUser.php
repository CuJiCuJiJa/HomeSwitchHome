<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionUser extends Model
{
    protected $table = 'auction_users';

    use SoftDeletes;
}
