<?php

namespace Mwl91\Books\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoanEvent extends Model
{
    use HasFactory;

    protected $table = 'book_loans_events';

    protected $fillable = [
        'aggregate_id',
        'payload',
        'event_name',
        'created_at',
    ];
}
