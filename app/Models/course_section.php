<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_section extends Model
{
    //
    protected $table = 'course_sections';
    protected $fillable = [
        'course_id',   // foreign key ke courses
        'title',       // nama section (misal: "Introduction", "Chapter 1")
        'order',       // urutan section
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function contents()
    {
        return $this->hasMany(course_content::class, 'section_id');
    }

}
