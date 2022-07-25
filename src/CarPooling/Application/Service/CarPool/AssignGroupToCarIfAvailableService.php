<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Service\CarPool;

use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;

class AssignGroupToCarIfAvailableService
{
    private CarRepositoryInterface $carRepository;
    private JourneyRepositoryInterface $journeyRepository;

    public function __construct(CarRepositoryInterface $carRepository, JourneyRepositoryInterface $journeyRepository)
    {
        $this->carRepository = $carRepository;
        $this->journeyRepository = $journeyRepository;
    }

    public function execute(Journey $journey)
    {
        $car = $this->carRepository->findAvailableCar($journey->people());

        if (null === $car || null !== $journey->carAssigned()) {
            return;
        }

        $journey->assignCar($car);
        $car->setSeatsAvailable($car->seatsAvailable() - $journey->people());

        $this->journeyRepository->update($journey);
        $this->carRepository->update($car);
    }
}