<?php

namespace Mwl91\Books\Tests\Application\CommandHandlers;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Event;
use Mwl91\Books\Application\Commands\ExtendBookLoanCommand;
use Mwl91\Books\Application\Commands\Handlers\ExtendBookLoanCommandHandler;
use Mwl91\Books\Application\Commands\Handlers\LendBookCommandHandler;
use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Domain\ValueObjects\Reader;
use Mwl91\Books\Infrastructure\Repositories\BookLoanEloquentRepository;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Mwl91\Books\Infrastructure\Repositories\InMemoryBookLoanRepository;
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

        $repository = new BookLoanEloquentRepository();

        // When:
        $handler = new LendBookCommandHandler($repository, $bookStockRepository);
        $handler($command);

        // Then:
        $bookLoan = $repository->find($processId);

        // Then:
        $this->assertInstanceOf(BookLoan::class, $bookLoan);
        $this->assertEquals($processId, $bookLoan->getKey());
        Event::assertDispatched(BookLoanCreated::class);
    }

    public function testItShouldCreateAndExtendLendProcess(): void
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

        $repository = new BookLoanEloquentRepository();

        // When:
        $handler = new LendBookCommandHandler($repository, $bookStockRepository);
        $handler($command);

        // When:
        $handler = new ExtendBookLoanCommandHandler($repository);
        $handler(new ExtendBookLoanCommand($processId, $reader));

        // Then:
        $bookLoan = $repository->find($processId);

        // Then:
        dd($bookLoan);
    }

    public function testItShouldRestoreFromPayloads(): void
    {
        // Given:
        $payload = '{"lentDate": "2024-07-23T18:02:58+00:00", "returnDate": "2024-08-22T18:03:18+00:00", "readerId":"8eff4559-11ec-4eba-a67f-3361d6802a3f","bookIds":["c181a46d-2e1d-4979-92db-8983d0c45ddc","d8ae68c7-9b73-43a9-b34d-45e537423800","fe24cedf-1f01-4884-bbef-91619d7aba77"]}';

        // When:
        $bookLoan = BookLoan::restoreFromEventsPayload([
            [
                'aggregate_id' => $processId = 'b7040af7-4796-45b4-848f-76b275ba953e',
                'payload' => $payload,
                'event_name' => BookLoanCreated::class,
                'id' => 'b7040af7-4796-45b4-848f-76b275ba953e',
            ]
        ]);

        // Then:
        $this->assertInstanceOf(BookLoan::class, $bookLoan);
        $this->assertEquals($processId, $bookLoan->getKey());
    }
}
