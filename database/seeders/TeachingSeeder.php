<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeachingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        $courses = Course::all();

        foreach ($teachers as $teacher) {
            $num = rand(1,2);

            $randomCourse = $courses->random($num);

            $teacher->courses()->attach($randomCourse);
        }
    }
}
