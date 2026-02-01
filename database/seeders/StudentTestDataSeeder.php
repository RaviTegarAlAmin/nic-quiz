<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $students = [
                ['name' => 'Siswa 1', 'gender' => 'Laki-Laki'],
                ['name' => 'Siswa 2', 'gender' => 'Perempuan'],
                ['name' => 'Siswa 3', 'gender' => 'Laki-Laki'],
                ['name' => 'Siswa 4', 'gender' => 'Perempuan'],
                ['name' => 'Siswa 5', 'gender' => 'Laki-Laki'],
                ['name' => 'Siswa 6', 'gender' => 'Perempuan'],
                ['name' => 'Siswa 7', 'gender' => 'Laki-Laki'],
                ['name' => 'Siswa 8', 'gender' => 'Perempuan'],
                ['name' => 'Siswa 9', 'gender' => 'Laki-Laki'],
                ['name' => 'Siswa 10', 'gender' => 'Perempuan'],
            ];

            foreach ($students as $index => $row) {

                // ===== USERS =====
                $user = User::create([
                    'name' => $row['name'],
                    'email' => 'siswa' . ($index + 1) . '@demo.test',
                    'password' => Hash::make('password'),
                ]);

                // ===== STUDENTS =====
                Student::create([
                    'user_id' => $user->id,
                    'classroom_id' => 14, // Test Classroom
                    'name' => $row['name'],
                    'nis' => '2024' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'gender' => $row['gender'],
                    'born_date' => fake()->dateTimeBetween('-17 years', '-13 years'),
                    'address' => fake()->address(),
                ]);
            }
        });
    }
}
