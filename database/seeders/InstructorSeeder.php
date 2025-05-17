<?php

namespace Database\Seeders;

use App\Helpers\Slug;
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
        $instructor = User::create([
            'name' => 'instructor',
            'email' => 'instructor@gmail.com',
            'username' => Slug::makeUser(new User(), 'instructor'),
            'password' => bcrypt('password'),
        ]);
        $instructor->assignRole('instructor');
        $instructor->save();
    }
}
