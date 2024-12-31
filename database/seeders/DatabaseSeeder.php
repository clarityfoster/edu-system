<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
            'role_id' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'role_id' => 2,
        ]);
        $roles = ['Admin', 'Instructor', 'Learner'];
        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
                'name' => $role,
            ]);
        }
    }
}
