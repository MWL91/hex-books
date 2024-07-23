<?php
declare(strict_types=1);

namespace Mwl91\Books\Application\Commands\Handlers;

use Mwl91\Books\Application\Commands\ExtendBookLoanCommand;
use Mwl91\Books\Application\Commands\LendBookCommand;
use Mwl91\Books\Domain\BookLoan;
use Mwl91\Books\Infrastructure\Repositories\BookStockRepository;
use Mwl91\Books\Infrastructure\Repositories\LocationWithTransport;
use Mwl91\Books\Infrastructure\Repositories\BookLoanRepository;

class ExtendBookLoanCommandHandler
{
    public function __construct(
        private BookLoanRepository $repository,
    )
    {
    }

    public function __invoke(ExtendBookLoanCommand $command): void
    {
        $bookLoan = $this->repository->find($command->getLoanId());
        $bookLoan->extendBookLoan($command);
        $this->repository->store($bookLoan);
    }
}
