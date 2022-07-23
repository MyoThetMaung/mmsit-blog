<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'saimon',
            'email' => 'saimon@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('saimon')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('saimon')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'role' => 'editor',
            'password' => Hash::make('saimon')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'author',
            'email' => 'author@gmail.com',
            'role' => 'author',
            'password' => Hash::make('saimon')
        ]);

    }
}
