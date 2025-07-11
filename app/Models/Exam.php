<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    //Static Variables
    public static array $status = ['finished', 'on hold', 'not started'];
    public static array $type = ['multiple choice', 'essay'];
}
