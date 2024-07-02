<?php
declare(strict_types=1);

namespace Mwl91\Books\Shared;

use Mwl91\Books\Application\Dtos\JsonDocument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AggregateChanged
{
    abstract protected function applyPayload(array $payload): void;

    public function __construct(
        protected readonly UuidInterface $aggregateId,
        protected readonly array         $payload,
    )
    {
        $this->applyPayload($payload);
    }

    public function getAggregateKey(): UuidInterface
    {
        return $this->aggregateId;
    }

    public static function occured(
        UuidInterface $aggregateId,
        array         $payload = [],
    ): static
    {
        $primitivePayload = self::getPrimitives($payload);

        $event = new static($aggregateId, $primitivePayload);
        event($event); // Laravel coupling is sad, but required...

        return $event;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getEventName(): string
    {
        return get_class($this);
    }

    public function dump(): array
    {
        return [
            'id' => (string)$this->getAggregateKey(),
            'payload' => json_encode($this->getPayload()),
            'created_at' => (new \DateTimeImmutable())->format('c'),
            'event_name' => $this->getEventName(),
        ];
    }

    public static function restore(array $dump): static
    {
        $eventClass = $dump['event_name'];

        return new $eventClass(
            Uuid::fromString($dump['id']),
            json_decode($dump['payload'], true)
        );
    }

    public static function getPrimitives(array $payload): array
    {
        $primitivePayload = [];
        foreach ($payload as $key => $value) {
            $primitivePayload[$key] = match (true) {
                $value instanceof \DateTimeInterface => $value->format('c'),
                $value instanceof UuidInterface => $value->toString(),
                is_array($value) => self::getPrimitives($value),
                is_object($value) => json_encode($value),
                default => $value,
            };
        }

        return $primitivePayload;
    }
}
