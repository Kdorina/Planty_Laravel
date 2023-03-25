<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MyPlant;

class Plant extends Model
{
    use HasFactory;

    public function my_plants(){
        return $this->hasMany(MyPlant::class);
    }

    protected $table = 'plants';
    protected $fillable=[

        "name",
        "imgpath",
        "description",
        "watering",
        "temperature",
        "light_requirement",
        "humidity",
        "heat_demand"
        
    ];
}
