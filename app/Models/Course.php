<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'slug',
        'thumbnail',
        'category',
        'duration', // Duration in minutes
        'price',
        'instructor_id', // Foreign key to the instructor
    ];
   
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function sections()
    {
        return $this->hasMany(course_section::class, 'course_id');
    }

}
