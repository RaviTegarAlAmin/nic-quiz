<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(ClassroomSeeder::class);
        $this->call(StudentSeeder::class); // Tied to Classroom
        $this->call(AdminSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(TeachingSeeder::class);
        $this->call(ExamSeeder::class);
        $this->call(QuestionSeeder::class);
    }
}
