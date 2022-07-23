<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

use Doctrine\ORM\PersistentCollection;

class Car
{
    private int $id;
    private int $seats;
    private int $seatsAvailable;
    private PersistentCollection $journeys;

    public function __construct(int $id, int $seats, int $seatsAvailable, PersistentCollection $journeys)
    {
        $this->id = $id;
        $this->seats = $seats;
        $this->seatsAvailable = $seatsAvailable;
        $this->journeys = $journeys;
    }

    public static function create(int $id, int $seats): self
    {
        return new self(
            $id,
            $seats,
            $seats,
            null
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function seats(): int
    {
        return $this->seats;
    }

    public function seatsAvailable(): int
    {
        return $this->seatsAvailable;
    }

    public function assignedJourneys(): PersistentCollection
    {
        return $this->journeys;
    }

}
