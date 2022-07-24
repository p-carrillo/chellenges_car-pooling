<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

class CarView
{
    private int $id;
    private int $seats;


    public function __construct(int $id, int $seats)
    {
        $this->id = $id;
        $this->seats = $seats;
    }

    public static function create(int $id, int $seats): self
    {
        return new self(
            $id,
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
}
