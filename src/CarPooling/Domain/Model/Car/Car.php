<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

use App\CarPooling\Domain\Model\Journey\Journey;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;

class Car
{
    private int $id;
    private int $seats;
    private int $seatsAvailable;

    public function __construct(int $id, int $seats, int $seatsAvailable)
    {
        $this->id = $id;
        $this->seats = $seats;
        $this->seatsAvailable = $seatsAvailable;
    }

    public static function create(int $id, int $seats): self
    {
        return new self(
            $id,
            $seats,
            $seats,
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

    public function setSeatsAvailable(int $seatsAvailable): void
    {
        $this->seatsAvailable = $seatsAvailable;
    }
}
