<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'instructor',
            'email' => 'instructor@gmail.com',
            'role' => 'instructor',
            'username' => Slug::makeUser(new User(), 'instructor'),
            'password' => bcrypt('password'),
        ]);
    }
}
