<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Carbon\Factory;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Making Classroom
        foreach (Classroom::$classrooms as $classroom) {
            Classroom::factory()->create([
                'name' => $classroom
            ]);
        }

    }
}
