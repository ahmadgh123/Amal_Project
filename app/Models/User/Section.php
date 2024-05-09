<?php

namespace App\Models\User;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = [
        'NameE',
        'NameA',
        'section_image'
    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }



    public function photos()
    {
        return $this->hasManyThrough(N_Course::class,Activity::class);
    }
}
