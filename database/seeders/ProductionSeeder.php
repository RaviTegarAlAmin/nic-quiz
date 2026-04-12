<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use App\Models\Teacher;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //First Admin
        $firstAdminUser = User::create(
            ['name' => 'superadmin',
             'email' => 'superadmin.mtsnuris@gmail.com',
             'email_verified_at' => now(),
             'password' => Hash::make(env('SUPERADMIN_PASSWORD'))
            ]
        );

        Admin::create([
            'user_id' => $firstAdminUser->id,
            'name' => $firstAdminUser->name,
            'gender' => 'Laki-Laki',
            'born_date' => now()->subYears(25),
            'address' => 'Sample Address',
        ]);

        //First Test Teacher
        $firstTeacherUser = User::create([
            'name' => 'gurutes',
            'email' => 'teacher.test@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(env('FIRST_TEACHER_PASSWORD'))
        ]);

        Teacher::create([
            'user_id' => $firstTeacherUser->id,
            'name' => $firstTeacherUser->name,
            'nip' => '202601001',
            'gender' => 'Perempuan',
            'born_date' => now()->subYears(30),
            'address' => 'Teacher Sample Address',
        ]);

        //First Test Student
        $firstClassroom = Classroom::create([
            'name' => 'test classroom',
            'capacity' => 32
        ]);

        $firstStudentUser = User::create([
            'name' => 'muridtes',
            'email' => 'student.test@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(env('FIRST_STUDENT_PASSWORD'))
        ]);

        Student::create([
            'user_id' => $firstStudentUser->id,
            'classroom_id' => $firstClassroom->id,
            'name' => $firstStudentUser->name,
            'nis' => '202602001',
            'gender' => 'Laki-Laki',
            'born_date' => now()->subYears(14),
            'address' => 'Student Sample Address',
        ]);
    }
}
