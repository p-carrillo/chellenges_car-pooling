<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Car\SetCarFleet;

use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;

class SetCarFleetHandler
{
    private CarRepositoryInterface $repository;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(SetCarFleetCommand $command): void
    {
        foreach ($command->carFleet() as $car) {
            $this->repository->create($car);
        }
    }
}