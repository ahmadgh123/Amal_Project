<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class N_Course extends Model
{
    use HasFactory;
    protected $table = 'n__courses';
    protected $fillable = [
        'name_image',
        'nameA',
        'activity_id',
        'n_image',
        'voice'
    ];
    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
