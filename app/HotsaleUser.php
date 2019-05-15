<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotsaleUser extends Model
{
    protected $table = 'hotsale_user';

    use SoftDeletes;
}
}
