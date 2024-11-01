<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate(); // Clear existing data

        $faker = Faker::create();

        try {
            DB::table('users')->insert([
                [
                    'full_name' => 'Amala Rajini',
                    'username' => 'Admin1', // Unique username
                    'email' => 'amala@gmail.com',
                    'password' => Hash::make('123'),
                    'role' => 'admin',
                    'status' => 'active',
                    'phone' => $faker->phoneNumber, // Correct method
                ],
                [
                    'full_name' => 'Amala Vendor',
                    'username' => 'Vendor1', // Unique username
                    'email' => 'vendor@gmail.com',
                    'password' => Hash::make('123'),
                    'role' => 'vendor',
                    'status' => 'active',
                    'phone' => $faker->phoneNumber, // Correct method
                ],
                [
                    'full_name' => 'Amala Customer',
                    'username' => 'Customer1', // Unique username
                    'email' => 'customer@gmail.com',
                    'password' => Hash::make('123'),
                    'role' => 'customer',
                    'status' => 'active',
                    'phone' => $faker->phoneNumber, // Correct method
                ],
            ]);
            echo "Users inserted successfully.\n";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
