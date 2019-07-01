<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\AuctionUser;
use App\HomeUser;
use App\Hotsale;
use App\Auction;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeHasAvailableWeek()
    {
        return ($this->available_weeks) > 0;
    }
    public function scopeIsAdmin()
    {
        return ($this->role->id) == 1;
    }
    public function scopeIsPremium()
    {
        return ($this->role->id) == 2;
    }
    public function scopeIsLowcost()
    {
        return ($this->role->id) == 3;
    }
    public function scopeHasValidCard()
    {
        return ($this->card_verification) == 1;
    }
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function hotsales()
    {
        return $this->hasMany('App\Hotsale');
    }
    public function auctions()
    {
        return $this->hasMany('App\AuctionUser');
    }
    public function reservations()
    {
        return $this->hasMany('App\HomeUser');
    }

    public function hasHotsale($date)
    {
        return Hotsale::where('user_id', $this->id)->where('week', $date)->get()->count() > 0;
    }

    public function hasAuction($date)
    {
        return Auction::where('winner_id', $this->id)->where('week', $date)->get()->count() > 0;
    }

    public function hasReservation($date)
    {
        return HomeUser::where('user_id', $this->id)->where('week', $date)->get()->count() > 0;
    }

    public function validUser($date)
    {
        if ($this->hasAvailableWeek() && !$this->trashed() && $this->hasValidCard() && !$this->hasHotsale($date) && !$this->hasAuction($date) && !$this->hasReservation($date)) {
            return true;
        }else{
            return false;
        }
    }
}
