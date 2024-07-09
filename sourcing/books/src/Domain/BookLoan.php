<?php

namespace Mwl91\Books\Domain;

use Mwl91\Books\Shared\AggregateChanged;
use Mwl91\Books\Shared\AggregateRoot;

class BookLoan extends AggregateRoot
{
    public function getKey(): string
    {
        // TODO: Implement getKey() method.
    }

    protected function apply(AggregateChanged $event): void
    {
        // TODO: Implement apply() method.
    }
}
