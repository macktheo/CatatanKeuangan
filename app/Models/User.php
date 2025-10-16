<?php

namespace App\Models;

// Impor yang dibutuhkan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Tambahkan 'role' untuk hak akses.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Relasi: Satu User dapat memiliki banyak Pemasukan.
     */
    public function pemasukan(): HasMany
    {
        return $this->hasMany(Pemasukan::class);
    }
    
    /**
     * Relasi: Satu User dapat memiliki banyak Pengeluaran.
     */
    public function pengeluaran(): HasMany
    {
        return $this->hasMany(Pengeluaran::class);
    }
    
    /**
     * Helper: Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}