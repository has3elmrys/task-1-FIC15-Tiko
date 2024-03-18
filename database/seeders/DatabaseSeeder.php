<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' =>'admin',
            'password' => Hash::make('password'),
            'phone'=>'12345678',
        ]);

        //seeder profile_clinics manual
        \App\Models\ProfileClinic::factory()->create([

            'name'=> 'Kartiko Clinic',
            'address'=>'Kampung Baru, Hj Soleh II',
            'phone'=>'0987634165752',
            'email'=>'dr.kartiko.@gmail.com',
            'doctor_name'=>'Dr. Kartiko',
            'unique_code'=>'DR001',
        ]);

        //call
         $this->call(DoctorSeeder::class);
    }
}
