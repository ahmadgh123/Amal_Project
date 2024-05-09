<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'date_of_birth',
        'location',
        'profile_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
