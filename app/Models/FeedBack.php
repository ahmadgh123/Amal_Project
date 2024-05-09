<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
