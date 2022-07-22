<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

class Car
{
    private int $id;
    private int $seats;

    public function __construct(int $id, int $seats)
    {
        $this->id = $id;
        $this->seats = $seats;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function seats(): int
    {
        return $this->seats;
    }
}
