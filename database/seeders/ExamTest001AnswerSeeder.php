<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTest001AnswerSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // 1. Fetch the teaching (course_id=1, teacher_id=3, classroom_id=1)
        // ---------------------------------------------------------
        $teaching = DB::table('teachings')
            ->where('course_id', 1)
            ->where('teacher_id', 3)
            ->where('classroom_id', 1)
            ->first();

        if (!$teaching) {
            dump("Teaching not found.");
            return;
        }

        // ---------------------------------------------------------
        // 2. Fetch the exam assignment linked to this teaching
        // ---------------------------------------------------------
        $examAssignment = DB::table('exam_assignments')
            ->where('teaching_id', $teaching->id)
            ->first();

        if (!$examAssignment) {
            dump("Exam assignment not found.");
            return;
        }

        // ---------------------------------------------------------
        // 3. Fetch the exam from exam_assignments
        // ---------------------------------------------------------
        $exam = DB::table('exams')
            ->where('id', 137)
            ->first();

        if (!$exam) {
            dump("Exam not found.");
            return;
        }

        // ---------------------------------------------------------
        // 4. Fetch exam takers
        // ---------------------------------------------------------
        $examTakers = DB::table('exam_takers')
            ->where('exam_assignment_id', 334)
            ->get();

        if ($examTakers->isEmpty()) {
            dump("Exam takers not found.");
            return;
        }

        // ---------------------------------------------------------
        // 5. Fetch the target essay question
        // ---------------------------------------------------------
        $waterCycleQuestion = DB::table('questions')
            ->where('exam_id', 137)
            ->where('type', 'essay')
            ->where('id', 1511)
            ->first();

        if (!$waterCycleQuestion) {
            dump(" not found.");
            return;
        }

        // ---------------------------------------------------------
        // 6. 10 unique essay answers
        // ---------------------------------------------------------
        $essayAnswers = [
            // 1. Reference answer
            "Acids and bases differ in their chemical properties and behaviors. Acids have a sour taste, release hydrogen ions (H⁺) in solution, and have a pH below 7. Examples include lemon juice and vinegar. Bases taste bitter, feel slippery, release hydroxide ions (OH⁻), and have a pH above 7. Examples include baking soda and soap. Both are commonly used in daily life for cleaning, cooking, and household products.",

            // 2. Good
            "Acids are substances with a pH less than 7 and often taste sour, like citrus fruits. Bases have a pH higher than 7 and feel slippery, such as soap or baking soda.",

            // 3. Good
            "Acids produce hydrogen ions in water and are found in items like vinegar. Bases release hydroxide ions and appear in products like detergents.",

            // 4. Good
            "Acids usually taste sour and react with metals, while bases are bitter and slippery. Lemon juice is an acid; toothpaste is a base.",

            // 5. Good
            "The key difference is their pH: acids are below 7 and bases are above 7. You encounter acids in foods like oranges and bases in products like hand soap.",

            // 6. Good
            "Acids donate H+ ions and bases donate OH− ions. Vinegar is a common acid, and baking soda is a common base.",

            // 7. Good
            "Acids and bases react differently; acids can neutralize bases. Everyday examples include stomach acid versus antacid tablets.",

            // 8. Wrong #1
            "Acids and bases are exactly the same and always have a pH of 7.",

            // 9. Wrong #2
            "Bases are only found in food, and acids are only found in cleaning products.",

            // 10. Wrong #3
            "Acids make solutions taste sweet, while bases turn them bright red.",
        ]

        ;

        // ---------------------------------------------------------
        // 7. Create answers for every exam taker
        // ---------------------------------------------------------
        foreach ($examTakers as $taker) {
            DB::table('answers')->insert([
                'exam_taker_id' => $taker->id,
                'question_id' => $waterCycleQuestion->id,
                'answer' => $essayAnswers[array_rand($essayAnswers)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        dump("Successfully seeded essay answers for ExamTest001.");
    }
}
