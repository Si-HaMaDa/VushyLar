<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', '=', 'admin@admin.com')->first();
        if (!$user) {
            User::factory()->create([
                'name' => 'HaMaDa',
                'email' => 'admin@admin.com',
                'type' => 'admin',
            ]);
        }

        User::factory(10)->create();
    }
}
