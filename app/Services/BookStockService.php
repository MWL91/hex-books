<?php

namespace App\Services;

use App\Models\BookStock;
use App\ValueObjects\Book;
use Ramsey\Uuid\UuidInterface;

class BookStockService
{
    public function addBookToStock(UuidInterface $id, Book $book, int $quantity): BookStock
    {
        return BookStock::create([
            'id' => $id,
            'name' => $book->getName(),
            'isbn' => $book->getIsbn(),
            'quantity' => $quantity,
            'in_stock' => $quantity,
        ]);
    }
}
