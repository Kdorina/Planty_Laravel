<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Water extends Model
{
    use HasFactory;

    protected $table = 'water';
    protected $fillable = [
        "id",
        "addWater",
        'user_id'
    ];
}
