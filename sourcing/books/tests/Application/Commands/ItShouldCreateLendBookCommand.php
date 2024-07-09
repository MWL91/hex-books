<?php

namespace Mwl91\Books\Tests\Application\Commands;

use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\ValueObjects\Reader;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ItShouldCreateLendBookCommand extends TestCase
{
    public function testShouldInstantiateReader(): void
    {
        // Given:
        $readerId = Uuid::uuid4();
        $isBlocked = false;

        // When:
        $instance = new Reader(
            $readerId,
            $isBlocked
        );

        // Then:
        $this->assertInstanceOf(Reader::class, $instance);
        $this->assertFalse($instance->isBlocked());
        $this->assertInstanceOf(UuidInterface::class, $instance->getKey());
    }

    public function testShouldInstantiateLendBookCommand(): void
    {
        // Given:
        $reader = new Reader(
            $readerId = Uuid::uuid4(),
            $isBlocked = false
        );

        // When:
        $instance = new LendBookCommand(
            $reader,
            [
                $book1 = Uuid::uuid4(),
                $book2 = Uuid::uuid4(),
                $book3 = Uuid::uuid4(),
            ]
        );

        // Then:
        $this->assertInstanceOf(LendBookCommand::class, $instance);
        $this->assertNotEmpty($instance->getKey());
    }

    public function testIdOfLendBookCommandShouldBeCreatedOnce(): void
    {
        // Given:
        $reader = new Reader(
            $readerId = Uuid::uuid4(),
            $isBlocked = false
        );
        $books = [
            $book1 = Uuid::uuid4(),
            $book2 = Uuid::uuid4(),
            $book3 = Uuid::uuid4(),
        ];
        $instance = new LendBookCommand(
            $reader,
            $books
        );

        // When:
        $id = $instance->getKey();
        $secondId = $instance->getKey();


        // Then:
        $this->assertSame($id, $secondId);
    }

    public function testIdOfLendBookCommandShouldBeAbleToSetManually(): void
    {
        // Given:
        $reader = new Reader(
            $readerId = Uuid::uuid4(),
            $isBlocked = false
        );
        $books = [
            $book1 = Uuid::uuid4(),
            $book2 = Uuid::uuid4(),
            $book3 = Uuid::uuid4(),
        ];
        $instance = new LendBookCommand(
            $reader,
            $books,
            $processId = Uuid::uuid4()
        );

        // When:
        $id = $instance->getKey();
        $secondId = $instance->getKey();


        // Then:
        $this->assertSame($id, $processId);
        $this->assertSame($secondId, $processId);
    }
}
