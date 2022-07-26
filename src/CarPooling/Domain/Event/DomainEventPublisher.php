<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Event;

class DomainEventPublisher
{
    private array $subscribers;

    public function __construct()
    {
        $this->subscribers = [];
    }

    public function subscribe($subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(DomainEventInterface $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}
