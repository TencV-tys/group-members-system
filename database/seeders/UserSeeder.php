<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin user exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'member_id' => null,
            ]);
        }

        // Check if John Doe exists
        if (!User::where('email', 'john@example.com')->exists()) {
            $member = Member::create([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'role' => 'Lead Developer',
                'bio' => 'Leading the development team with 8+ years of experience.',
                'age' => 34,
                'profile_photo' => null,
            ]);

            User::create([
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'member_id' => $member->id,
            ]);
        }

        // Check if Sarah Smith exists
        if (!User::where('email', 'sarah@example.com')->exists()) {
            $member2 = Member::create([
                'first_name' => 'Sarah',
                'last_name' => 'Smith',
                'role' => 'UI/UX Designer',
                'bio' => 'Creating beautiful and intuitive user experiences.',
                'age' => 29,
                'profile_photo' => null,
            ]);

            User::create([
                'name' => 'Sarah Smith',
                'username' => 'sarahsmith',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'member_id' => $member2->id,
            ]);
        }

        $this->command->info('Users and members created successfully!');
        $this->command->info('Admin login: admin@example.com / password123');
        $this->command->info('User login: john@example.com or johndoe / password123');
        $this->command->info('User login: sarah@example.com or sarahsmith / password123');
    }
}