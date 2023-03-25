<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plant;

class MyPlant extends Model
{
    use HasFactory;

    protected $table = 'my_plants';

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function plants(){
        return $this->belongsTo(Plant::class);
    }

    protected $fillable=[

        "user_id",
        "plant_id"
    ];
}
