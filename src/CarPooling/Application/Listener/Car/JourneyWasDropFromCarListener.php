<?php

namespace App\CarPooling\Application\Listener\Car;

use App\CarPooling\Domain\Event\DomainEventInterface;
use App\CarPooling\Domain\Event\DomainEventSubscriber;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Event\JourneyWasDropFromCarEvent;

class JourneyWasDropFromCarListener implements DomainEventSubscriber
{
    private  CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository
    )
    {
        $this->carRepository = $carRepository;
    }

    public function handle(DomainEventInterface $event): void
    {
        $car = $this->carRepository->getOneById($event->carId());
        $car->setSeatsAvailable($car->seatsAvailable() + $event->people());
        $this->carRepository->update($car);
    }

    public function isSubscribedTo(DomainEventInterface $event): bool
    {
        return $event instanceof JourneyWasDropFromCarEvent;
    }
}