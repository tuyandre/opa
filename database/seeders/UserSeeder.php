<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrInsert(['email' => 'admin@opa.rw'], [
            'name' => 'Super Admin',
            'email' => 'admin@opa.rw',
            'username' => 'admin',
            'telephone' => '0780000000',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'is_super_admin' => true,
        ]);
    }
}
