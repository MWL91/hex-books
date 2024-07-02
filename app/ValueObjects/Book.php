<?php

namespace App\ValueObjects;

use Ramsey\Uuid\UuidInterface;

class Book
{
    public function __construct(
        private string $name,
        private string $isbn,
        private string $quantity,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
