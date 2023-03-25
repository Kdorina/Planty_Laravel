<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutrientSolution extends Model
{
    use HasFactory;

    protected $table = 'nutrients';
    
    protected $fillable = [

        "id",
        "addNutrient",
        "user_id"
    ];
}
