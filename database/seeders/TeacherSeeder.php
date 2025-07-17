<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(15)->create();
        foreach ($users as $user) {
            Teacher::factory()->create([
                'name' => $user->name,
                'user_id' => $user->id
            ]);
        }
    }
}
