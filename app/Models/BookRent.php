<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'book_rents';

    protected $guarded = [];

    protected $casts = [
        'rented_at' => 'datetime',
    ];
}
