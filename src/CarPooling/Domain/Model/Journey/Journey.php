<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Journey;

use App\CarPooling\Domain\Model\Car\Car;

class Journey
{
    private int $id;
    private int $people;
    private ?Car $carAssigned;
    private \DateTimeInterface $dateRequest;

    public function __construct(int $id, int $people, ?Car $carAssigned, \DateTimeInterface $dateRequest)
    {
        $this->id = $id;
        $this->people = $people;
        $this->carAssigned = $carAssigned;
        $this->dateRequest = $dateRequest;
    }

    public static function create(int $id, int $people): self
    {
        return new self(
            $id,
            $people,
            null,
            new \DateTime('now')
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function people(): int
    {
        return $this->people;
    }

    public function dateRequest(): \DateTimeInterface
    {
        return $this->dateRequest;
    }

    public function carAssigned(): ?Car
    {
        return $this->carAssigned;
    }

    public function assignCar(Car $car): void
    {
        $this->carAssigned = $car;
    }

    public function setPeople(int $people): void
    {
        $this->people = $people;
    }
}
