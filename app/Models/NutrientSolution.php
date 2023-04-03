<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NutrientSolution extends Model
{
    use HasFactory;

    protected $table = 'nutrients';

    public function users(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [

        "id",
        "addNutrient",
        "user_id"
    ];
}
