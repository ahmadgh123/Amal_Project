<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activities';
    protected $fillable = [
        'NameE',
        'NameA',
        'level_activity',
        'section_id',
        'activity_image'
    ];

    public function section()
    {
        return $this->belongsToMany(Section::class);
    }
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function n_course()
    {
        return $this->hasOne(N_Course::class);
    }
}
