<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'slug',
        'user_id',
        'type',
        'image',
        'voice'
    ];
}
