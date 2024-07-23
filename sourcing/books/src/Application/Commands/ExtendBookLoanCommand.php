<?php
declare(strict_types=1);

namespace Mwl91\Books\Application\Commands;

use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Domain\ValueObjects\Reader;
use Ramsey\Uuid\UuidInterface;

final class ExtendBookLoanCommand
{
    private \DateTimeInterface $returnDate;

    public function __construct(
        private readonly UuidInterface $loanId,
        private readonly Reader $reader,
        ?\DateTimeInterface $returnDate = null
    )
    {
        if($returnDate === null) {
            $returnDate = new \DateTimeImmutable(BookLoan::DEFAULT_RETURN_TIME);
        }

        $this->returnDate = $returnDate;
    }

    public function getLoanId(): UuidInterface
    {
        return $this->loanId;
    }

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function isReaderBlocked(): bool
    {
        return $this->reader->isBlocked();
    }

    public function getReturnDate(): \DateTimeInterface
    {
        return $this->returnDate;
    }
}
