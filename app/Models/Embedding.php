<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Embedding extends Model
{
    public function answer(){
        return $this->belongsTo(Answer::class);
    }
}
