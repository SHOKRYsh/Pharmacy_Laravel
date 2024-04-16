<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'image_url',
    ];

    public function donation()
    {
        return $this->hasMany(Donation::class, 'patient_id');
    }
    public function alarm()
    {
        return $this->hasMany(Alarm::class, 'patient_id');
    }
}
