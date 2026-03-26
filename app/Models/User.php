<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isKetuaRT(): bool
    {
        return $this->role === 'ketua_rt';
    }

    public function isSekretarisRT(): bool
    {
        return $this->role === 'sekretaris_rt';
    }

    public function isBendaharaRT(): bool
    {
        return $this->role === 'bendahara_rt';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin'    => 'Super Admin',
            'ketua_rt'      => 'Ketua RT',
            'sekretaris_rt' => 'Sekretaris RT',
            'bendahara_rt'  => 'Bendahara RT',
            default         => $this->role,
        };
    }
}
