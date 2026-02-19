<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'ISBN',
        'total_copies',
        'available_copies',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
