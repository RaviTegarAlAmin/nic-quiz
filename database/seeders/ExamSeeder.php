<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\Teacher;
use App\Models\Teaching;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::all()->each(function ($teacher) {
            // Patch teacher fields that factory skipped
            $teacher->update([
                'name' => fake()->name(),
                'gender' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            ]);

            // Get courses the teacher actually teaches
            $teachings = Teaching::where('teacher_id', $teacher->id)->get();

            foreach ($teachings as $teaching) {
                // Each course -> 2 to 4 exams
                $exams = Exam::factory()
                    ->count(rand(2, 4))
                    ->create([
                        'teacher_id' => $teacher->id,
                        'course_id' => $teaching->course_id,
                    ]);

                foreach ($exams as $exam) {
                    // Each exam has at least 2 assignments
                    ExamAssignment::factory()
                        ->count(rand(2, 3))
                        ->create([
                            'exam_id' => $exam->id,
                            'teaching_id' => $teaching->id,
                            'published' => fake()->boolean(70), // random published status
                        ]);
                }
            }
        });
    }
}
