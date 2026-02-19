<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitor_name',
        'loan_date',
        'return_date',
        'book_id',
    ];

    protected $casts = [
        'loan_date' => 'timestamp',
        'return_date' => 'timestamp',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isReturned(): bool
    {
        return $this->return_date !== null;
    }
}
