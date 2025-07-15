<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, Authenticatable;

    protected $fillable = ['classroom_id','nis','name','gender','born_date','address'];

    public function user() :BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function classroom() :BelongsTo {
        return $this->belongsTo(Classroom::class);
    }

    public function grades() :HasMany {
        return $this->hasMany(Grade::class);
    }

    public function answers() :HasMany {
        return $this->hasMany(Answer::class);
    }

}
