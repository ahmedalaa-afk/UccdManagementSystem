<?php

namespace Database\Seeders;

use App\Helpers\Slug;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = User::create([
            'name' => 'Super Manager',
            'email' => 'super@gmail.com',
            'password' => bcrypt('123456789'),
            'username' => Slug::makeUser(new User(), 'Super Manager'),
        ]);
        $super->assignRole('super_admin');
        $super->save();
    }
}
