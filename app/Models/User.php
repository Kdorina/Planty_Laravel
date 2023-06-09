<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MyPlant;
use App\Models\Water;
use App\Models\NutrientSolution;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getId(){
        return $this->id;
    }
    public function myplant(){
        return $this->hasMany(MyPlant::class);
    }
    public function water(){
        return $this->hasMany(Water::class);
    }
    public function nutrientSolution(){
        return $this->hasMany(NutrientSolution::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
}
