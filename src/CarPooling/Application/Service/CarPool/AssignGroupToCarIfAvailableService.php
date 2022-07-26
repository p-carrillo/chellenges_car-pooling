<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Service\CarPool;

use App\CarPooling\Domain\Event\DomainEventPublisher;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Event\JourneyWasAssignedToCarEvent;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;

class AssignGroupToCarIfAvailableService
{
    private CarRepositoryInterface $carRepository;
    private JourneyRepositoryInterface $journeyRepository;
    private DomainEventPublisher $publisher;

    public function __construct(
        CarRepositoryInterface     $carRepository,
        JourneyRepositoryInterface $journeyRepository,
        DomainEventPublisher       $publisher,
    )
    {
        $this->carRepository = $carRepository;
        $this->journeyRepository = $journeyRepository;
        $this->publisher = $publisher;
    }

    public function execute(Journey $journey)
    {
        $car = $this->carRepository->findAvailableCar($journey->people());

        if (null === $car || null !== $journey->carAssigned()) {
            return;
        }

        $journey->assignCar($car);
        $this->journeyRepository->update($journey);
        $this->publisher->publish(new JourneyWasAssignedToCarEvent($car->id(), $journey->people()));
    }
}