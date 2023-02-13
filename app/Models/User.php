<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\WelcomeUserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //new
        'phone',
        'city',
        'state',
        'country',
        'address',
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

    // public static function boot() {
    //     parent::boot();
    //     self::saved(function ($model) {
    //         Notification::send($model, new WelcomeUserNotification());
    //     });
    // }

    public function generateCode()
    {
        $code = rand(100000, 999999);
        UserCode::updateOrCreate([
            'user_id' => auth()->user()->id,
        ],[
            'user_id' => auth()->user()->id,
            'code' => $code
        ]);
        $receiverNumber = auth()->user()->phone;
        $message = "Your 6 Digit OTP Number is ". $code;
        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $from_number = env("TWILIO_FROM");
    
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $from_number, 
                'body' => $message]);
        } catch (\Exception $e) {
            
        }
    } 
}
