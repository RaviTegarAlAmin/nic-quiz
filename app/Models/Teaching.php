<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

       public function course(){
        return $this->belongsTo(Course::class);
    }
}
