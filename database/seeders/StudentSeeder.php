<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $classrooms = Classroom::all();

        foreach ($classrooms as $classroom) {
            //Making user related to Student
            $students = 32;
            $users = User::factory()->count($students)->create();

            foreach ($users as $user) {
                if ($user->id % 2 == 0) {
                    Student::factory()->create(
                        [
                            'name' => $user->name,
                            'user_id' => $user->id,
                            'classroom_id' => $classroom->id,
                            'gender' => 'Laki-Laki',

                        ]
                    );
                } else {
                    Student::factory()->create(
                        [
                            'name' => $user->name,
                            'user_id' => $user->id,
                            'classroom_id' => $classroom->id,
                            'gender' => 'Perempuan',
                        ]
                    );
                }
            }
        }
    }
}
