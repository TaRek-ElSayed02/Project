<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Patient extends Model
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    
    protected $fillable = ['Name', 'Email', 'Password', 'Doctor_id', 'OxyGenerator_id', 'Age', 'Height', 'Weight', 'Temperature', 'Password_Confirmation'];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }
    public function oxygenGenerator()
    {
        return $this->hasOne(Oxygen_Generator::class);
    }

    public function disease()
    {
        return $this->hasOne(Disease::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
