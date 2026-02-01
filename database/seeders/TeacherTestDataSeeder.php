<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $data = [
                [
                    'name' => 'Zaeni Rokhi',
                    'email' => 'zaeni.rokhi@demo.test',
                    'course_id' => 2,
                    'gender' => 'Laki-Laki',
                ],
                [
                    'name' => 'Arwiyah',
                    'email' => 'arwiyah@demo.test',
                    'course_id' => 1,
                    'gender' => 'Perempuan',
                ],
                [
                    'name' => 'Januri',
                    'email' => 'januri@demo.test',
                    'course_id' => 3,
                    'gender' => 'Laki-Laki',
                ],
                [
                    'name' => 'Dwi Oktaviani Lestari',
                    'email' => 'dwi.oktaviani@demo.test',
                    'course_id' => 4,
                    'gender' => 'Perempuan',
                ],
            ];

            foreach ($data as $row) {

                // ===== USERS =====
                $user = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make('password'),
                ]);

                // ===== TEACHERS =====
                $teacher = Teacher::create([
                    'user_id' => $user->id,
                    'name' => $row['name'],
                    'nip' => fake()->numerify('19########'),
                    'gender' => $row['gender'],
                    'born_date' => fake()->dateTimeBetween('-45 years', '-25 years'),
                    'address' => fake()->address(),
                ]);

                // ===== CLASSROOM LOGIC =====
                // 4 random dari ID 1–13
                $randomClassrooms = Classroom::whereBetween('id', [1, 13])
                    ->inRandomOrder()
                    ->limit(4)
                    ->pluck('id')
                    ->toArray();

                // + Test Classroom ID 14
                $classroomIds = array_merge($randomClassrooms, [14]);

                // ===== TEACHINGS (TOTAL 5) =====
                foreach ($classroomIds as $classroomId) {
                    Teaching::create([
                        'teacher_id' => $teacher->id,
                        'course_id' => $row['course_id'],
                        'classroom_id' => $classroomId,
                    ]);
                }
            }
        });
    }
}
