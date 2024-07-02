<?php

namespace Mwl91\Books\Infrastructure\Repositories;

use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Infrastructure\Repositories\Eloquent\BookLoanEvent;
use Mwl91\Books\Shared\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

class BookLoanEloquentRepository implements BookLoanRepository
{

    public function store(BookLoan $entity): void
    {
        /** @var AggregateChanged $event */
        foreach ($entity->releaseEvents() as $event) {
            BookLoanEvent::create([
                'aggregate_id' => $event->getAggregateKey(),
                'payload' => json_encode($event->getPayload()),
                'event_name' => $event->getEventName()
            ]);
        }
    }

    public function find(UuidInterface $uuid): ?BookLoan
    {
        $transportEvent = BookLoanEvent::where('aggregate_id', $uuid->toString())->get();
        if ($transportEvent->isEmpty()) {
            return null;
        }

        return BookLoan::restoreFromEventsPayload(
            $transportEvent->map(
                fn(BookLoanEvent $event) => [...$event->toArray(), 'id' => $uuid->toString()]
            )->toArray()
        );
    }
}
