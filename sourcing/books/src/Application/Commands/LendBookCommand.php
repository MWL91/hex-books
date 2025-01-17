<?php
declare(strict_types=1);

namespace Mwl91\Books\Application\Commands;

use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Domain\ValueObjects\Reader;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class LendBookCommand
{
    private readonly UuidInterface $id;
    private array $bookIds;
    private \DateTimeInterface $returnDate;

    public function __construct(
        private Reader $reader,
        array $bookIds,
        ?UuidInterface $loanId = null,
        ?\DateTimeInterface $returnDate = null
    )
    {
        if($loanId !== null) {
            $this->id = $loanId;
        }

        if($returnDate === null) {
            $returnDate = new \DateTimeImmutable(BookLoan::DEFAULT_RETURN_TIME);
        }

        foreach($bookIds as $bookId) {
            if(!($bookId instanceof UuidInterface)) {
                throw new \InvalidArgumentException('Book ID must be an instance of UuidInterface');
            }
        }

        $this->bookIds = $bookIds;
        $this->returnDate = $returnDate;
    }

    public function getKey(): UuidInterface
    {
        if(!isset($this->id)) {
            $this->id = Uuid::uuid4();
        }

        return $this->id;
    }

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function getBookIds(): array
    {
        return $this->bookIds;
    }

    public function isReaderBlocked(): bool
    {
        return $this->reader->isBlocked();
    }

    public function getReaderId(): UuidInterface
    {
        return $this->reader->getKey();
    }

    public function getReturnDate(): \DateTimeInterface
    {
        return $this->returnDate;
    }
}
