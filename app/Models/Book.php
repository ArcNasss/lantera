<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
    ];

    /**
     * Get category of this book
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get loans for this book
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
