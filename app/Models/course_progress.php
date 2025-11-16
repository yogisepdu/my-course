<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_progress extends Model
{
    //
    protected $table = 'course_progress';

    protected $fillable = ['user_id', 'course_content_id', 'completed_at'];

    protected $dates = ['completed_at'];

    public function content()
    {
        return $this->belongsTo(course_content::class, 'course_content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
