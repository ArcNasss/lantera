<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'alasan_ditolak',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Get peminjam (user)
     */
    public function peminjam()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get petugas verifier
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Get book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get return book
     */
    public function returnBook()
    {
        return $this->hasOne(ReturnBook::class);
    }
}
