<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_content extends Model
{
    //
    protected $table = 'course_contents';
    protected $fillable = [
        'section_id',     // foreign key ke course_sections
        'title',          // judul materi
        'content_type',   // video, pdf, text
        'content_url',    // link file / video
        'body',           // isi teks (optional)
        'order',          // urutan materi dalam section
    ];

    public function section()
    {
        return $this->belongsTo(course_section::class, 'section_id');
    }

    public function completedBy()
    {
        return $this->belongsToMany(
            User::class,
            'course_progress',
            'course_content_id',
            'user_id'
        )->withTimestamps();
    }
}
