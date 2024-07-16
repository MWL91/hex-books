<?php

namespace Mwl91\Books\Infrastructure\Repositories;

use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Shared\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

class InMemoryBookLoanRepository implements BookLoanRepository
{
    public function __construct(
        private array $entities = []
    )
    {
    }

    public function store(BookLoan $entity): void
    {
        $this->entities[$entity->getKey()] = array_map(fn(AggregateChanged $event) => $event->dump(), $entity->releaseEvents());
    }

    public function find(UuidInterface $uuid): ?BookLoan
    {
        if (!isset($this->entities[$uuid->toString()])) {
            return null;
        }

        dd($this->entities[$uuid->toString()] ?? []);

        return BookLoan::restoreFromEventsPayload($this->entities[$uuid->toString()] ?? []);
    }
}
