<?php

namespace Mwl91\Books;

use Illuminate\Support\ServiceProvider;
use Mwl91\Books\Infrastructure\Repositories\BookLoanEloquentRepository;
use Mwl91\Books\Infrastructure\Repositories\BookLoanRepository;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BookLoanRepository::class, BookLoanEloquentRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/books.php',
            'books',
        );
    }
}
