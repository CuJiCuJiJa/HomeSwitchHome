<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use SoftDeletes;

    protected $fillable = ['location', 'descrip', 'active'];

    /*public function hotsales()
    {
    	return $this->hasMany('App\Hotsales');
    }

    public function scopeHasActiveHotsales()
    {
    	return $query($this->hotsales())->where('active', true);
    }*/

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

    public function scopeIsOccupied($date)
    {
        //EN CASO DE QUE EXISTAN DEVUELVE RESERVA, HOTSALE O SUBASTE PARA UNA SEMANA DADA
        return $query->whereHas('reservations', function($q) use ($date)
            {
                $q->where('week', $date);
            })->orWhereHas('auctions', function($q) use ($date)
            {
                $q->where('winner_id', '!=', null)->where('week', $date);
            })->orWhereHas('hotsales', function($q) use ($date)
            {
                $q->where('week', $date);
            });
    }

}
