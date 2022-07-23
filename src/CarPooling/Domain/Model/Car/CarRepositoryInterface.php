<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Car;

interface CarRepositoryInterface
{
    public function getById(int $id): ?array;

    public function loadCarFleet(array $carFleet): void;

    public function update(Car $car): void;

    public function reset(): void;

    public function findAvailableCar(int $seatsRequested): ?car;
}
