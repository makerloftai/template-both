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
        // The seeded user's email + password come from one of two
        // env-var conventions, in precedence order:
        //   1. INITIAL_USER_EMAIL / INITIAL_USER_PASSWORD - set by
        //      MakerLoft on production deploys via the DigitalOcean
        //      App Spec. Visible at runtime to user code.
        //   2. MAKERLOFT_USER_EMAIL / MAKERLOFT_USER_PASSWORD - set by
        //      the preview orchestrator at container spawn. Stripped
        //      from the env before php-fpm starts, so only the
        //      seeder sees them.
        //   3. Hardcoded test@example.com / 'password' fallback for
        //      local migrate:fresh --seed, CI, forks deployed outside
        //      MakerLoft, etc.
        // Both paths source the same pair of project-level credentials
        // shown in the MakerLoft View credentials modal, so the user
        // signs in with the exact value that surface displays.
        $email = (string) (env('INITIAL_USER_EMAIL') ?? env('MAKERLOFT_USER_EMAIL', 'test@example.com'));
        $name = (string) env('MAKERLOFT_USER_NAME', 'Test User');
        $password = (string) (env('INITIAL_USER_PASSWORD') ?? env('MAKERLOFT_USER_PASSWORD', 'password'));

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );
    }
}
