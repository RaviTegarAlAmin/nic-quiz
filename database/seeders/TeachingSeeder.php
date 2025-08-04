<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Teaching;
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
        $classrooms = Classroom::all();

        $teachings = [];

        foreach ($teachers as $teacher) {
            $assignedCourses = $courses->random(rand(1, 2));
            foreach ($assignedCourses as $course) {
                $assignedClasses = $classrooms->random(rand(1, 3));
                foreach ($assignedClasses as $classroom) {
                    $teachings[] = [
                        'teacher_id' => $teacher->id,
                        'course_id' => $course->id,
                        'classroom_id' => $classroom->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        Teaching::insert($teachings);
    }
}
