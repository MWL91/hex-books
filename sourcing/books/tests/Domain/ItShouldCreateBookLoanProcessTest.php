<?php

namespace Mwl91\Books\Tests\Domain;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Event;
use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Domain\ValueObjects\Reader;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ItShouldCreateBookLoanProcessTest extends TestCase
{
    public function testItShouldCreateLendProcess(): void
    {
        // Given:
        Event::fake();
        $reader = new Reader(
            $readerId = Uuid::uuid4(),
            $isBlocked = false
        );
        $books = [
            $book1 = Uuid::uuid4(),
            $book2 = Uuid::uuid4(),
            $book3 = Uuid::uuid4(),
        ];
        $command = new LendBookCommand(
            $reader,
            $books,
            $processId = Uuid::uuid4()
        );
        $bookStockRepository = $this->createMock(BookStockRepository::class);
        $bookStockRepository->expects($this->once())
            ->method('checkAvailability')
            ->willReturn(true);

        // When:
        $process = BookLoan::loanBook($command, $bookStockRepository);
        $events = $process->releaseEvents();

        // Then:
        $this->assertInstanceOf(BookLoanCreated::class, $events[0]);
        $this->assertEquals($processId, $process->getKey());
        Event::assertDispatched(BookLoanCreated::class);
    }
}
