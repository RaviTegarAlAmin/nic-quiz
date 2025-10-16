<?php

namespace Database\Seeders;

use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamAssignment::with('exam')->get()->each(function ($examAssignment) {
            $classroomId = $examAssignment->teaching->classroom_id;

            $students = Student::where('classroom_id', $classroomId)
                ->inRandomOrder()
                ->limit(rand(8, 15))
                ->get();

            foreach ($students as $student) {
                $startAt = fake()->dateTimeBetween($examAssignment->start_at, $examAssignment->end_at);

                $examTaker = ExamTaker::firstOrCreate(
                    [
                        'exam_assignment_id' => $examAssignment->id,
                        'student_id' => $student->id,
                    ],
                    [
                        'last_active_at' => $startAt,
                        'start_at' => $startAt,
                        'status' => $examAssignment->status === 'finished' ? 'finished' : 'ongoing',
                        'duration_used' => 0,
                    ]
                );

                if ($examAssignment->status === 'finished') {
                    $durationMinutes = $examAssignment->duration;
                    $finishAt = (clone $startAt)->modify('+' . rand(10, $durationMinutes) . ' minutes');

                    if ($finishAt > $examAssignment->end_at) {
                        $finishAt = $examAssignment->end_at;
                    }

                    $examTaker->update([
                        'finished_at' => $finishAt,
                    ]);
                }
            }
        });

    }
}
