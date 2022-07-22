<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

interface CarRepositoryInterface
{
    public function getById(int $id): ?array;

    public function create(\stdClass $car): void;

    public function update(Car $car): void;
}
