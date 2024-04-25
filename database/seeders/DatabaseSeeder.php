<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'dipinpnambiar@gmail.com',
        // ]);

        Form::factory()
            ->count(5)
            ->hasFields(5)
            ->create();

    }
}
