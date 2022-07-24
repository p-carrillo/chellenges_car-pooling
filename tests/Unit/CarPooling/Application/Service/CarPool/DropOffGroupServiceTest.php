<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Service\CarPool;

use App\CarPooling\Application\Service\CarPool\DropOffGroupService;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DropOffGroupServiceTest extends TestCase
{
    private CarRepositoryInterface $carRepository;
    private JourneyRepositoryInterface $journeyRepository;
    private DropOffGroupService $service;
    private Journey $journey;
    private Car $car;


    protected function setUp(): void
    {
        parent::setUp();
        $this->carRepository = $this->createMock(CarRepositoryInterface::class);
        $this->journeyRepository = $this->createMock(JourneyRepositoryInterface::class);
        $this->journey = $this->createMock(Journey::class);
        $this->car = $this->createMock(Car::class);
        $this->service = new DropOffGroupService(
            $this->carRepository,
            $this->journeyRepository,
        );
    }

    public function testCarFoundAndPeopleDropped(): void
    {
        $car = Car::create(1,2);
        $journey = Journey::create(1,2);
        $journey->assignCar($car);

        $this->journeyRepository->expects(static::once())
            ->method('remove')
        ;

        $this->carRepository->expects(static::once())
            ->method('update')
        ;

        $this->service->execute($journey);
    }

    public function testCarNotFoundAndPeopleDroppedButNoUpdate(): void
    {
        $journey = Journey::create(1,2);

        $this->journeyRepository->expects(static::once())
            ->method('remove')
        ;

        $this->carRepository->expects(static::never())
            ->method('update')
        ;

        $this->service->execute($journey);
    }

}