<?php

namespace Mwl91\Books\Domain\Events;

use Mwl91\Books\Shared\AggregateChanged;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BookLoanCreated extends AggregateChanged implements BookEvent
{
    private UuidInterface $readerId;
    private array $bookIds;

    protected function applyPayload(array $payload): void
    {
        $this->readerId = Uuid::fromString($payload['readerId']);
        $this->bookIds = array_map(fn(string $uuid) => Uuid::fromString($uuid), $payload['bookIds']);
    }

    public function getReaderId(): UuidInterface
    {
        return $this->readerId;
    }

    public function getBookIds(): array
    {
        return $this->bookIds;
    }
}
