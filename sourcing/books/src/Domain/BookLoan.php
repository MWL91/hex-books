<?php

namespace Mwl91\Books\Domain;

use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Mwl91\Books\Shared\AggregateChanged;
use Mwl91\Books\Shared\AggregateRoot;

final class BookLoan extends AggregateRoot
{
    public function getKey(): string
    {
        // TODO: Implement getKey() method.
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
        // TODO: Implement apply() method.
    }
}
