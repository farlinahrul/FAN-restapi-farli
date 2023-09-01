<?php

namespace Database\Seeders;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        User::factory()->create();
        User::factory(10)->state(
            new Sequence(
                fn($sequence) => [
                    'supervisor_npp' => fake()->boolean(50) ? User::all()->random()->npp : null,
                ]
            )
        )->create()->each(function ($item) {
            Presence::factory()->state(
                new Sequence(
                    fn($sequence) => [
                        'user_id' => $item,
                    ]
                )
            )->create();
        });
    }
}