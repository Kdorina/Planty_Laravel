<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plant;
use Illuminate\Foundation\Auth\User as Authenticatable;


class MyPlant extends Model
{
    use HasFactory;

    protected $table = 'myplants';

    public function plants(){
        return $this->belongsTo(Plant::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }

    protected $fillable=[

        "user_id",
        "plant_id"
    ];
}
