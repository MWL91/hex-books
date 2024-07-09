<?php
declare(strict_types=1);

namespace Mwl91\Books\Domain\ValueObjects;

use Ramsey\Uuid\UuidInterface;

final class Reader
{
    public function __construct(
        private UuidInterface $id,
        private bool $isBlocked
    )
    {
    }

    public function getKey(): UuidInterface
    {
        return $this->id;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }
}
