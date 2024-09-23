<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Tour;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'notation',
        'fcm_token',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'user_tour');
    }

    public function generateOTP()
{
    
        $this->otp = rand(111111, 999999);
        $this->otp_till = now()->addMinutes(1);
        $this->save();
    
}

public function resetOTP()
{
   
        $this->otp = null;
        $this->otp_till = null;
        $this->save();
    
}
// Add this to the User model
public function routeNotificationForFcm()
{
    return $this->fcm_token;
}
public function reservations()
{
    return $this->hasMany(Reservation::class);
}

}
