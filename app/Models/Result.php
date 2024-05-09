<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    public $fillable = [

        'user_id',
        'activity_id',
        'type_result',
        'repet',
        'time_spent',
    ];

}
