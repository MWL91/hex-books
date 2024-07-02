<?php
declare(strict_types=1);

namespace Mwl91\Books\Application\Commands\Handlers;

use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Infrastructure\Repositories\LocationWithTransport;
use Mwl91\Books\Infrastructure\Repositories\BookLoanRepository;

class LendBookCommandHandler
{
    public function __construct(
        private BookLoanRepository $repository
    )
    {
    }

    public function __invoke(LendBookCommand $query): void
    {
//        $bookLoan = BookLoan::create($query);
//        $this->repository->store($bookLoan);
    }
}
