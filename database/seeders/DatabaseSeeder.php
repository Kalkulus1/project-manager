<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::firstOrCreate([
            'name' => 'Kalkulus',
            'email' => 'kalkulus132@gmail.com',
            'password' => Hash::make('Kalkulus32?!')
        ]);

        $this->call(ProjectSeeder::class);
    }
}
