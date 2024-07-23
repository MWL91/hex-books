<?php

namespace Mwl91\Books\Domain\Events;

use Mwl91\Books\Shared\AggregateChanged;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BookLoanCreated extends AggregateChanged implements BookEvent
{
    private UuidInterface $readerId;
    private array $bookIds;
    private \DateTimeInterface $lentDate;
    private \DateTimeInterface $returnDate;

    protected function applyPayload(array $payload): void
    {
        $this->readerId = Uuid::fromString($payload['readerId']);
        $this->bookIds = array_map(fn(string $uuid) => Uuid::fromString($uuid), $payload['bookIds']);
        $this->lentDate = new \DateTimeImmutable($payload['lentDate']);
        $this->returnDate = new \DateTimeImmutable($payload['returnDate']);
    }

    public function getReaderId(): UuidInterface
    {
        return $this->readerId;
    }

    public function getBookIds(): array
    {
        return $this->bookIds;
    }

    public function getLentDate(): \DateTimeInterface
    {
        return $this->lentDate;
    }

    public function getReturnDate(): \DateTimeInterface
    {
        return $this->returnDate;
    }


}
