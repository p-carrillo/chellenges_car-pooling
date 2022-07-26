<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Service\CarPool;

use App\CarPooling\Domain\Event\DomainEventPublisher;
use App\CarPooling\Domain\Model\Journey\Event\JourneyWasDropFromCarEvent;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;

class DropOffGroupService
{
    private JourneyRepositoryInterface $journeyRepository;
    private DomainEventPublisher $publisher;

    public function __construct(
        JourneyRepositoryInterface $journeyRepository,
        DomainEventPublisher $publisher,
    )
    {
        $this->journeyRepository = $journeyRepository;
        $this->publisher = $publisher;
    }

    public function execute(Journey $journey)
    {
        $car = $journey->carAssigned();
        $this->journeyRepository->remove($journey);
        if (null !== $car) {
            $this->publisher->publish(new JourneyWasDropFromCarEvent($car->id(), $journey->people()));
        }
    }
}