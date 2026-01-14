<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnBook extends Model
{
    use HasFactory;

    protected $table = 'return_books';

    protected $fillable = [
        'loan_id',
        'tanggal_pengembalian',
        'kondisi',
        'denda',
        'status',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
    ];

    /**
     * Get loan
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
