<?php

namespace App\Services;

use App\Enums\BookRentStatus;
use App\Enums\PenaltyStatus;
use App\Models\BookRent;
use App\Models\BookStock;
use App\Models\UserPenalty;
use App\ValueObjects\Book;
use Illuminate\Contracts\Auth\Authenticatable;
use Ramsey\Uuid\UuidInterface;

class RentBookService
{
    public function rent(Authenticatable $user, UuidInterface $bookId): BookRent
    {
        BookStock::where('id', $bookId)->decrement('in_stock');
        return BookRent::create([
            'book_id' => $bookId->toString(),
            'user_id' => $user->getAuthIdentifier(),
            'rented_at' => now(),
            'status' => BookRentStatus::RENTED,
        ]);
    }

    public function return(Authenticatable $user, UuidInterface $rentId): BookRent
    {
        $rent = BookRent::findOrFail($rentId);
        $rent->update([
            'returned_at' => now(),
            'status' => BookRentStatus::RETURNED,
        ]);
        BookStock::where('id', $rent->book_id)->increment('in_stock');

        $days = (int) ($rent->rented_at->diffInDays($rent->returned_at) - 30);
        if($days > 0) {
            UserPenalty::create([
                'user_id' => $user->getAuthIdentifier(),
                'book_rent_id' => $rentId->toString(),
                'status' => PenaltyStatus::UNPAID,
                'amount' => $days > 0 ? $days * 1000 : 0,
            ]);
        }

        return $rent;
    }
}
