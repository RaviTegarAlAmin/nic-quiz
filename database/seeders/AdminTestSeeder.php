<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['name' => 'admin1'],
            [
                'password' => Hash::make('admin1'),
                'email' => 'admin1@demo.test'
            ]
        );

        Admin::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Admin Test',
                'gender' => 'Laki-Laki',
                'born_date' => '1990-01-01',
                'address' => 'Alamat Admin Demo',
            ]
        );
    }
}
