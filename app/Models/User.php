<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

        // --- PENAMBAHAN UNTUK STATUS ONLINE ---
        'last_seen', // <--- WAJIB ADA AGAR BISA DI-UPDATE

        'otp',             // <-- Tambahan baru
        'otp_expires_at',  // <-- Tambahan baru
        'saldo',
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

            // --- WAJIB ADA AGAR BISA DIHITUNG WAKTU ---
            'last_seen' => 'datetime',
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

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Accessor untuk URL foto profil (Support lokal storage & OAuth URL)
     */
    public function getFotoProfilUrlAttribute()
    {
        if (!$this->foto_profil) {
            return null;
        }

        if (preg_match('#^https?://#i', $this->foto_profil)) {
            $cleanUrl = preg_replace('/\?sz=\d+$/', '', $this->foto_profil);
            return preg_replace('/=s\d+-c$/', '=s0-c', $cleanUrl);
        }

        return asset('storage/' . $this->foto_profil);
    }

    /**
     * Otomatis normalisasi role ke: admin, pekebun, user
     */
    public function setRoleAttribute($value)
    {
        if ($value === 'petani' || $value === 'pekebun durian') {
            $value = 'pekebun';
        } elseif ($value === 'konsumen') {
            $value = 'user';
        }
        $this->attributes['role'] = $value;
    }

    public function getRoleAttribute($value)
    {
        if ($value === 'petani' || $value === 'pekebun durian') {
            return 'pekebun';
        } elseif ($value === 'konsumen') {
            return 'user';
        }
        return $value;
    }
}