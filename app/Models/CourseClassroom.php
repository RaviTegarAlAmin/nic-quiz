<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseClassroom extends Model
{
    public function course() :BelongsTo {
        return $this->belongsTo(Course::class);
    }

    public function classroom() : BelongsTo {
        return $this->belongsTo(Classroom::class);
    }
}
