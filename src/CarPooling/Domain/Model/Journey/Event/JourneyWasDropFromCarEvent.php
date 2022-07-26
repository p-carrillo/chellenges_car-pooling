<?php

namespace App\CarPooling\Domain\Model\Journey\Event;

use App\CarPooling\Domain\Event\DomainEventInterface;

class JourneyWasDropFromCarEvent implements DomainEventInterface
{
    private int $carId;

    private int $people;

    public function __construct(
        int $carId,
        int $people,
    )
    {
        $this->carId = $carId;
        $this->people = $people;
    }

    public function carId(): int
    {
        return $this->carId;
    }

    public function people(): int
    {
        return $this->people;
    }
}