<?php

namespace Mwl91\Books\Shared;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class UuidValueObject
{
    public function __construct(protected UuidInterface $id)
    {
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $id): static
    {
        return new static(Uuid::fromString($id));
    }
}
