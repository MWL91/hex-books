<?php

namespace Mwl91\Books\Domain;

use Mwl91\Books\Application\Commands\ExtendBookLoanCommand;
use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Domain\Events\LoanExtended;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Mwl91\Books\Shared\AggregateChanged;
use Mwl91\Books\Shared\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

final class BookLoan extends AggregateRoot
{
    public const string DEFAULT_RETURN_TIME = '+30 days';

    private UuidInterface $id;
    private UuidInterface $readerId;
    private array $bookIds;
    private \DateTimeInterface $lentDate;
    private \DateTimeInterface $returnDate;
    private int $extendCount = 0;

    public function getKey(): string
    {
        return $this->id;
    }

    public function countExtends(): int
    {
        return $this->extendCount;
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
            'lentDate' => new \DateTimeImmutable('now'),
            'returnDate' => $command->getReturnDate(),
        ]));

        return $bookLoan;
    }

    public function extendBookLoan(ExtendBookLoanCommand $command): void
    {
        if($this->returnDate < new \DateTimeImmutable('now')) {
            throw new \RuntimeException('Book loan is already expired');
        }

//        if($this->returnDate >= new \DateTimeImmutable('-3 days')) {
//            throw new \RuntimeException('Book loan cannot be extended');
//        }

        if($command->isReaderBlocked()) {
            throw new \RuntimeException('Reader is blocked');
        }

        if($this->extendCount >= 1) {
            throw new \RuntimeException('Book loan cannot be extended more than 1 times');
        }

        $this->record(LoanExtended::occured($this->id, [
            'newReturnDate' => $command->getReturnDate(),
        ]));
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (true) {
            case $event instanceof BookLoanCreated:
                $this->applyBookLoanCreated($event);
                break;
            case $event instanceof LoanExtended:
                $this->applyLoanExtended($event);
                break;
        }
    }

    private function applyBookLoanCreated(BookLoanCreated $event): void
    {
        $this->id = $event->getAggregateKey();
        $this->readerId = $event->getReaderId();
        $this->bookIds = $event->getBookIds();
        $this->lentDate = $event->getLentDate();
        $this->returnDate = $event->getReturnDate();
    }

    private function applyLoanExtended(LoanExtended $event): void
    {
        $this->returnDate = $event->getNewReturnDate();
        $this->extendCount++;
    }
}
