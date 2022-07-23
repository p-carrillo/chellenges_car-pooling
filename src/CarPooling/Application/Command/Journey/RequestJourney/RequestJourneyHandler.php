<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Journey\RequestJourney;

use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;

class RequestJourneyHandler
{
    private JourneyRepositoryInterface $repository;

    public function __construct(JourneyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(RequestJourneyCommand $command): void
    {
        $journey = Journey::create($command->id(), $command->people());
        $this->repository->create($journey);
    }
}