<?php
declare(strict_types=1);

namespace Mwl91\Books\Tests\Infrastructure\Repositories;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mwl91\Books\Tests\TestCase;

final class BookLoanEloquentRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testItShouldStoreBookLoanDomain(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function testItShouldLoadBookLoanDomain(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function testItShouldNotLoadBookLoanDomainWhenNotExists(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }
}
