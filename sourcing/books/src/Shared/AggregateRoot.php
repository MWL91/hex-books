<?php
declare(strict_types=1);

namespace Mwl91\Books\Shared;

abstract class AggregateRoot
{
    protected array $events = [];

    abstract public function getKey(): string;

    abstract protected function apply(AggregateChanged $event): void;

    protected function record(AggregateChanged $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @param array $eventsPayload
     * @return static
     */
    public static function restoreFromEventsPayload(array $eventsPayload): static
    {
        $events = [];
        foreach ($eventsPayload as $event) {
            $events[] = (AggregateChanged::restore($event));
        }
        return self::restore($events);
    }

    /**
     * @param AggregateChanged[] $events
     * @return static
     */
    public static function restore(array $events): static
    {
        $instance = new static();
        foreach ($events as $event) {
            $instance->apply($event);
        }
        return $instance;
    }
}
