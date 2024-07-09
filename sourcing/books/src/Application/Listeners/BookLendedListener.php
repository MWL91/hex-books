<?php

namespace Mwl91\Books\Application\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Mwl91\Books\Domain\Events\BookLoanCreated;
use Mwl91\Books\Infrastructure\Repositories\BookLoanRepository;
use Mwl91\Books\Infrastructure\Services\TransportService;

class BookLendedListener implements ShouldQueue
{
    public function __construct(
        private readonly BookStockRepository $bookStockRepository,
    )
    {
    }

    public function handle(BookLoanCreated $event): void
    {
        $this->bookStockRepository->reserve($event->getBookIds());
    }
}
