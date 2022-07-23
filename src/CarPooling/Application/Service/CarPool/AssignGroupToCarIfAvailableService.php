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
    private Journey $journey;

    public function __construct()
    {

    }

    public function execute()
    {

    }
}