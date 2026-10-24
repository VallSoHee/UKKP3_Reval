<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tiga role yang dikenal aplikasi
    const ROLE_ADMIN    = 'admin';
    const ROLE_PETUGAS  = 'petugas';
    const ROLE_CUSTOMER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    // Nama rute halaman pertama setelah login, sesuai role.
    // Awalan rute admin dan petugas sama dengan nama rolenya ('admin.' dan 'petugas.').
    public function halamanAwal(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN   => 'admin.pengaduan.index',
            self::ROLE_PETUGAS => 'petugas.pengaduan.index',
            default            => 'pengaduan.create',
        };
    }

    // Nama role untuk ditampilkan, misalnya di sidebar
    public function labelRole(): string
    {
        return ucfirst($this->role);
    }
}
