<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengeluaran extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'pengeluaran';

    /**
     * The attributes that are mass assignable.
     * Mengizinkan pengisian massal dari Controller.
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'deskripsi',
        'jumlah',
        'bukti_gambar', // Untuk fasilitas foto/gambar
    ];

    /**
     * Relasi: Setiap pengeluaran dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}