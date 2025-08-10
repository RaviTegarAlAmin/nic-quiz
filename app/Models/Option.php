<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
    protected $fillable = ['option', 'label', 'question_id'];
    public array $label = ['A', 'B', 'C', 'D'];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
