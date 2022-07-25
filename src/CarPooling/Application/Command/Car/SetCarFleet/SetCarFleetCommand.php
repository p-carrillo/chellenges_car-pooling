<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Car\SetCarFleet;

class SetCarFleetCommand
{
    private array $carFleet;

    public function __construct(
        array $carFleet,
    ) {
        $this->carFleet = $carFleet;
    }

    public function carFleet(): array
    {
        return $this->carFleet;
    }
}