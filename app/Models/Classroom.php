<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    /** @use HasFactory<\Database\Factories\ClassroomFactory> */
    use HasFactory;

    protected $fillable = ['name', 'grade', 'capacity'];

    public static array $classrooms = ['7.1', '7.2', '7.3', '7.4', '7.5', '8.1', '8.2', '8.3', '8.4', '8.5', '9.1', '9.2', '9.3'];

    //Relation to other models

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teaching(): BelongsTo
    {
        return $this->belongsTo(Teaching::class);
    }

    //Query Builder
    protected function scopemaleStudents()
    {
        return $this->students->where('gender', 'Laki-Laki')->count();
    }

    protected function scopefemaleStudents()
    {
        return $this->students->where('gender', 'Perempuan')->count();
    }
}
