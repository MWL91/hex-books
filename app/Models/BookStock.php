<?php

namespace App\Models;

use App\Enums\BookRentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStock extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'books_stock';

    protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
        'in_stock' => 'integer',
        'rented_at' => 'datetime',
        'returned_at' => 'datetime',
        'status' => BookRentStatus::class,
    ];
}
