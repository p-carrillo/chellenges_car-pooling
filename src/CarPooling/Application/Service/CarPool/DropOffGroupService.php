<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Service\CarPool;

use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;


class DropOffGroupService
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
        $car = $journey->carAssigned();

        if (null !== $car) {
            $car->setSeatsAvailable($car->seatsAvailable() + $journey->people());
            $this->carRepository->update($car);
        }

        $this->journeyRepository->remove($journey);
    }
}