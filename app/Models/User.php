<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'no_telepon',
        'alamat',
        'foto_profil',

        // --- PENAMBAHAN UNTUK LARAVEL SOCIALITE ---
        'provider',
        'provider_id',
        // ------------------------------------------
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

    // --- RELASI ---

    /**
     * Relasi One-to-Many: Satu User (Admin) bisa punya banyak Konten Edukasi
     */
    public function kontenEdukasi(): HasMany
    {
        return $this->hasMany(KontenEdukasi::class);
    }

    /**
     * Relasi One-to-Many: Satu User (Petani) bisa punya banyak Produk
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * Relasi One-to-Many: Satu User (Konsumen) bisa punya banyak Pesanan
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}