<?php

namespace Mwl91\Books\Tests\Domain;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Event;
use Mwl91\Books\Application\Commands\ExtendBookLoanCommand;
use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Domain\Events\LoanExtended;
use Mwl91\Books\Domain\ValueObjects\Reader;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ItShouldExtendBookLoanTest extends TestCase
{
    public function testItShouldExtendBookLoanTest(): void
    {
        // Given:
        Event::fake();
        $readerId = "8eff4559-11ec-4eba-a67f-3361d6802a3f";
        $reader = new Reader(
            Uuid::fromString($readerId),
            false
        );
        $payload = '{"lentDate": "2024-08-22T18:02:58+00:00", "returnDate": "2024-08-22T18:03:18+00:00", "readerId":"'.$readerId.'","bookIds":["c181a46d-2e1d-4979-92db-8983d0c45ddc","d8ae68c7-9b73-43a9-b34d-45e537423800","fe24cedf-1f01-4884-bbef-91619d7aba77"]}';
        $bookLoan = BookLoan::restoreFromEventsPayload([
            [
                'aggregate_id' => $processId = 'b7040af7-4796-45b4-848f-76b275ba953e',
                'payload' => $payload,
                'event_name' => BookLoanCreated::class,
                'id' => 'b7040af7-4796-45b4-848f-76b275ba953e',
            ]
        ]);

        // When:
        $command = new ExtendBookLoanCommand(
            Uuid::fromString($processId),
            $reader,
        );
        $bookLoan->extendBookLoan($command);

        // Then:
        Event::assertDispatched(LoanExtended::class);
        $this->assertEquals(1, $bookLoan->countExtends());
    }
}
