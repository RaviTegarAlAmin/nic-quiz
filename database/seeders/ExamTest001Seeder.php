<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Teaching;
use App\Models\Classroom;
use App\Models\Student;

class ExamTest001Seeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1. Find the teaching
        $teaching = Teaching::where('teacher_id', 3)
            ->where('course_id', 1)
            ->where('classroom_id', 1)
            ->firstOrFail();

        $classroom = $teaching->classroom;

        // 2. Get all students in that classroom
        $students = Student::where('classroom_id', $classroom->id)->get();

        // 3. Create 1 exam
        $examId = DB::table('exams')->insertGetId([
            'teacher_id' => $teaching->teacher_id,
            'course_id' => $teaching->course_id,
            'title' => 'Ujian IPA Semester 1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Create 1 exam assignment
        $examAssignmentId = DB::table('exam_assignments')->insertGetId([
            'exam_id' => $examId,
            'teaching_id' => $teaching->id,
            'start_at' => $now,
            'end_at' => $now->copy()->addHours(2),
            'duration' => 120,
            'status' => 'finished   ',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Assign all students to the exam
        foreach ($students as $student) {
            DB::table('exam_takers')->insert([
                'exam_assignment_id' => $examAssignmentId,
                'student_id' => $student->id,
                'last_active_at' => null,
                'start_at' => $now,
                'finished_at' => $now,
                'status' => 'finished',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 6. Create 40 questions
        $shortEssays = [
            "Explain photosynthesis in plants.",
            "Define Newton's first law of motion.",
            "What is the boiling point of water?",
            "Name three states of matter.",
            "What does DNA stand for?"
        ];

        $longEssays = [
            "Describe how the water cycle works including evaporation, condensation, and precipitation.",
            "Explain the process of digestion from ingestion to elimination.",
            "Discuss the structure of the solar system and the planets' positions relative to the sun.",
            "Explain how energy is transferred in an ecosystem through food chains and food webs.",
            "Describe the differences between acids and bases, including examples in daily life."
        ];

        $mcQuestions = [];
        for ($i = 1; $i <= 30; $i++) {
            $mcQuestions[] = "Multiple choice question $i about science.";
        }

        $allQuestions = array_merge($shortEssays, $longEssays, $mcQuestions);

        foreach ($allQuestions as $index => $question) {
            $isEssay = $index < 10; // first 10 are essays
            DB::table('questions')->insert([
                'exam_id' => $examId,
                'teacher_id' => $teaching->teacher_id,
                'question' => $question,
                'type' => $isEssay ? 'essay' : 'multiple_choice',
                'weight' => $isEssay ? 5 : 1,
                'ref_answer' => $isEssay ? $question . " (example answer)" : null,
                'ref_answer_embed' => $isEssay ? json_encode([]) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
