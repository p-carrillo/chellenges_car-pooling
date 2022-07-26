<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEventInterface $event): void;

    public function isSubscribedTo(DomainEventInterface $event): bool;
}
