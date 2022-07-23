<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Car\SetCarFleet;

use App\CarPooling\Application\Service\CarPool\ResetApplicationService;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;

class SetCarFleetHandler
{
    private CarRepositoryInterface $repository;
    private ResetApplicationService $resetApplicationService;

    public function __construct(
        CarRepositoryInterface $repository,
        ResetApplicationService $resetApplicationService
    )
    {
        $this->repository = $repository;
        $this->resetApplicationService = $resetApplicationService;
    }

    public function handle(SetCarFleetCommand $command): void
    {

        $this->resetApplicationService->execute();

        $carFleet = [];
        foreach ($command->carFleet() as $carRequest) {
            $carFleet[] = Car::create($carRequest->id, $carRequest->seats);
        }

        $this->repository->loadCarFleet($carFleet);
    }
}