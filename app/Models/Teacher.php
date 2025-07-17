<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    protected $fillable = ['nip','name','gender','born_date','address'];

    public function teachings() {
        return $this->hasMany(Teaching::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class,'teachings')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

}
