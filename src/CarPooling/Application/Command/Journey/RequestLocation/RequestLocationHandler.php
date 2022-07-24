<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Journey\RequestLocation;

use App\CarPooling\Application\Service\CarPool\AssignGroupToCarIfAvailableService;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarView;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestLocationHandler
{
    private JourneyRepositoryInterface $repository;

    public function __construct(
        JourneyRepositoryInterface $repository,
    )
    {
        $this->repository = $repository;
    }

    public function handle(RequestLocationCommand $command): CarView
    {
        $journey = $this->repository->getOneById($command->id());

        if (null === $journey) {
            throw new NotFoundHttpException();
        }

        $car = $journey->carAssigned();
        return CarView::create($car->id(), $car->seats());
    }
}