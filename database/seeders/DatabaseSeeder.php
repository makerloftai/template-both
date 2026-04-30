<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Direct insert (not factory) so the seeder runs under
        // composer install --no-dev, where fakerphp/faker is absent
        // and UserFactory::definition()'s fake() calls would crash.
        //
        // MAKERLOFT_USER_NAME / MAKERLOFT_USER_EMAIL are forwarded by
        // the orchestrator at preview spawn so the dev can log in as
        // themselves on a fresh preview. Both fall back to a generic
        // test user when the seeder runs outside that environment
        // (local migrate:fresh --seed, CI, etc.).
        $email = (string) env('MAKERLOFT_USER_EMAIL', 'test@example.com');
        $name = (string) env('MAKERLOFT_USER_NAME', 'Test User');

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
    }
}
