<?php

namespace Mwl91\Books\Domain\Events;

use Mwl91\Books\Shared\AggregateChanged;

class BookLoanCreated extends AggregateChanged implements BookEvent
{
    // TODO: Explain why this works like that -> mapping!
    protected function applyPayload(array $payload): void
    {
    }
}
