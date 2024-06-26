<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // query builder
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'testing1@example.com',
            'password' => Hash::make('password'),
        ]);

        // Eloquent
        User::create([
            'name' => Str::random(10),
            'email' => 'testing2@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
