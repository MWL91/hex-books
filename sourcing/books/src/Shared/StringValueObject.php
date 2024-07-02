<?php
declare(strict_types=1);

namespace Mwl91\Books\Shared;

abstract class StringValueObject
{
    public function __construct(protected string $text)
    {
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
