<?php

namespace Mwl91\Books\Infrastructure\Repositories;

interface BookStockRepository
{
    public function checkAvailability(array $bookIds): bool;
}
