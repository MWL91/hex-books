<?php

namespace Mwl91\Books\Domain\Events;

use Mwl91\Books\Shared\AggregateChanged;

final class LoanExtended extends AggregateChanged
{
    private readonly \DateTimeInterface $newReturnDate;

    protected function applyPayload(array $payload): void
    {
        $this->newReturnDate = new \DateTimeImmutable($payload['newReturnDate']);
    }

    public function getNewReturnDate(): \DateTimeInterface
    {
        return $this->newReturnDate;
    }
}
