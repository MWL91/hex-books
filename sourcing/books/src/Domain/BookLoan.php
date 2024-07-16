<?php

namespace Mwl91\Books\Domain;

use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Mwl91\Books\Shared\AggregateChanged;
use Mwl91\Books\Shared\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

final class BookLoan extends AggregateRoot
{
    private UuidInterface $id;
    private UuidInterface $readerId;
    private array $bookIds;

    public function getKey(): string
    {
        return $this->id;
    }

    public static function loanBook(LendBookCommand $command, BookStockRepository $bookStockRepository): self
    {
        // if's
        if(!$bookStockRepository->checkAvailability($command->getBookIds())) {
            throw new \RuntimeException('Books are not available');
        }

        if($command->isReaderBlocked()) {
            throw new \RuntimeException('Reader is blocked');
        }

        $bookLoan = new self();
        $bookLoan->record(BookLoanCreated::occured($command->getKey(), [
            'readerId' => $command->getReaderId(),
            'bookIds' => $command->getBookIds(),
        ]));

        return $bookLoan;
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (true) {
            case $event instanceof BookLoanCreated:
                $this->applyBookLoanCreated($event);
                break;
        }
    }

    private function applyBookLoanCreated(BookLoanCreated $event): void
    {
        $this->id = $event->getAggregateKey();
        $this->readerId = $event->getReaderId();
        $this->bookIds = $event->getBookIds();
    }
}
