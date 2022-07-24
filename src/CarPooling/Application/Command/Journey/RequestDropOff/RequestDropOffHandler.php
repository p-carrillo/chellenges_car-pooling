<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Journey\RequestDropOff;

use App\CarPooling\Application\Service\CarPool\AssignGroupToCarIfAvailableService;
use App\CarPooling\Application\Service\CarPool\DropOffGroupService;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarView;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestDropOffHandler
{
    private JourneyRepositoryInterface $repository;
    private DropOffGroupService $dropOffService;

    public function __construct(
        JourneyRepositoryInterface $repository,
        DropOffGroupService $dropOffService
    )
    {
        $this->repository = $repository;
        $this->dropOffService = $dropOffService;
    }

    public function handle(RequestDropOffCommand $command): void
    {
        $journey = $this->repository->getOneById($command->id());

        if (null === $journey) {
            throw new NotFoundHttpException();
        }

        $this->dropOffService->execute($journey);
    }
}