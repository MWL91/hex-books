<?php

namespace Mwl91\Books;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelServiceProvider;
use Mwl91\Books\Application\Listeners\BookLendedListener;
use Mwl91\Books\Domain\Events\BookLoanCreated;

class EventServiceProvider extends LaravelServiceProvider
{
    protected $listen = [
        BookLoanCreated::class => [
            BookLendedListener::class,
        ],
    ];
}
