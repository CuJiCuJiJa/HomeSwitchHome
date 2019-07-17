<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use SoftDeletes;

    protected $fillable = ['location', 'descrip', 'active'];

    public function hasActiveHotsales()
    {
    	return $this->hotsales()->where('active', true);
    }

    public function auctions()
    {
        return $this->hasMany('App\Auction');
    }

    public function reservations()
    {
        return $this->hasMany('App\HomeUser');
    }

    public function hotsales()
    {
        return $this->hasMany('App\Hotsale');
    }

    public function scopeIsOccupied($query, $date)
    {

        //DEVUELVE TRUE EN CASO DE QUE LA RESIDENCIA ESTÉ OCUPADA PARA ESA SEMANA, FALSE EN CASO CONTRARIO
        return $query->whereHas('reservations', function($query) use ($date)
            {
                $query->where('week', $date)->where('home_id', $this->id);

            })->orWhereHas('auctions', function($query) use ($date)
            {
                $query->where('winner_id', '!=', null)->where('week', $date)->where('home_id', $this->id);;

            })->orWhereHas('hotsales', function($query) use ($date)
            {
                $query->where('week', $date)->where('home_id', $this->id);
            })->get()->count() != 0;
    }

}
