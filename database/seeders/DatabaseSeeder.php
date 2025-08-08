<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Douglas Silvestrini',
            'email' => 'douglassilvestrini@gmail.com',
        ]);

        User::factory(24)->create();
    }
}
