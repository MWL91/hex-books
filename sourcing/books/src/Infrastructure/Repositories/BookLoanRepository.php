<?php

namespace Mwl91\Books\Infrastructure\Repositories;

use Mwl91\Books\Domain\BookLoan;
use Ramsey\Uuid\UuidInterface;

interface BookLoanRepository
{
    public function store(BookLoan $entity): void;

    public function find(UuidInterface $uuid): ?BookLoan;
}
