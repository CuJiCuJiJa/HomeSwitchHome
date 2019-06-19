<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    public function scopeHasAvailableWeek($query)
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
        return $this->card_verification;
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
}