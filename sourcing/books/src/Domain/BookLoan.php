<?php

namespace Mwl91\Books\Domain;

use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Application\Dtos\ShippingDocument;
use Mwl91\Books\Application\Dtos\ShippingOrderConfirmation;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Domain\Events\BookOrdered;
use Mwl91\Books\Infrastructure\Repositories\LocationWithTransport;
use Mwl91\Books\Infrastructure\Services\TransportService;
use Mwl91\Books\Shared\AggregateChanged;
use Mwl91\Books\Shared\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class BookLoan extends AggregateRoot
{
}
