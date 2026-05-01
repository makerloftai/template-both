<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Filament v3 rejects login for any user whose model does not
     * implement the FilamentUser interface when APP_ENV is anything
     * other than 'local'. The MakerLoft preview orchestrator sets
     * APP_ENV=preview, so without this method every /admin login
     * silently fails - even when the credentials are correct - because
     * Filament's panel auth treats the request as production-grade.
     *
     * Default to "any authenticated user can reach /admin" because
     * stock starter projects ship a single seeded admin and no role
     * system. Apps that grow into multi-user deployments should
     * tighten this (e.g. `return $this->is_admin;` after adding the
     * column).
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
