<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Siswa',
                'email' => 'Siswa@binus.ac.id',
                'type' => 0,
                'password'=> bcrypt('1234567890'),
            ],
            [
                'name' => 'Guru',
                'email' => 'Guru@binus.ac.id',
                'type' => 1,
                'password'=> bcrypt('1234567890'),
            ],
            [
                'name' => 'Admin',
                'email' => 'Admin@binus.ac.id',
                'type' => 2,
                'password'=> bcrypt('1234567890'),
            ]
        ]);
    }
}
