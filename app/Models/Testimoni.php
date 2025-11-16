<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    //
    protected $table = 'testimonis';

    protected $fillable = [
        'name',
        'job',
        'description',
        'profile_picture',
    ];
}
