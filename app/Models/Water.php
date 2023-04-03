<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Water extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsTo(User::class);
    }

    protected $table = 'waters';
    protected $fillable = [
        "id",
        "addWater",
        'user_id'
    ];
}
