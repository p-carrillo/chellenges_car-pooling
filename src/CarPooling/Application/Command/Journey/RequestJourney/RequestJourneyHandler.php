<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Journey\RequestJourney;

use App\CarPooling\Application\Service\CarPool\AssignGroupToCarIfAvailableService;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;

class RequestJourneyHandler
{
    private JourneyRepositoryInterface $repository;
    private AssignGroupToCarIfAvailableService $assignToCarService;

    public function __construct(
        JourneyRepositoryInterface $repository,
        AssignGroupToCarIfAvailableService $assignToCarService
    )
    {
        $this->repository = $repository;
        $this->assignToCarService = $assignToCarService;
    }

    public function handle(RequestJourneyCommand $command): void
    {
        $journey = $this->repository->getOneById($command->id());

        if ( null === $journey ) {
            $journey = Journey::create($command->id(), $command->people());
            $this->repository->create($journey);
        }

        $this->assignToCarService->execute($journey);
    }
}