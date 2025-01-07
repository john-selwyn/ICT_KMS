<?php

// File: database/seeders/StaffUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => 'Staff User ' . $i,
                'email' => 'staff' . $i . '@example.com',
                'password' => Hash::make('password'), // Default password for all users
                'role' => 'staff', // Set the role to 'staff'
            ]);
        }
    }
}
