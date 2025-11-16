<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    //
    protected $fillable = [
        'user_id',
        'job',
        'profile_picture',
        'links_twitter',
        'links_linkedin',
        'links_facebook',
        'links_instagram',
        'links_youtube',
    ];
    
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }
    
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
