<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Service\CarPool;

use App\CarPooling\Application\Service\CarPool\AssignGroupToCarIfAvailableService;
use App\CarPooling\Domain\Event\DomainEventPublisher;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class AssignGroupToCarIfAvailableServiceTest extends TestCase
{
    private DomainEventPublisher $publisher;
    private CarRepositoryInterface $carRepository;
    private JourneyRepositoryInterface $journeyRepository;
    private AssignGroupToCarIfAvailableService $service;
    private Journey $journey;


    protected function setUp(): void
    {
        parent::setUp();
        $this->carRepository = $this->createMock(CarRepositoryInterface::class);
        $this->journeyRepository = $this->createMock(JourneyRepositoryInterface::class);
        $this->publisher = $this->createMock(DomainEventPublisher::class);
        $this->journey = $this->createMock(Journey::class);
        $this->service = new AssignGroupToCarIfAvailableService(
            $this->carRepository,
            $this->journeyRepository,
            $this->publisher,
        );
    }

    public function testCarFoundAndAssign(): void
    {
        $this->carRepository->expects(static::once())
            ->method('findAvailableCar')
            ->willReturn(Car::create(1,4))
        ;

        $this->journeyRepository->expects(static::once())
            ->method('update')
        ;

        $this->journey->expects(static::once())
            ->method('assignCar')
        ;

        $this->publisher->expects(static::once())
            ->method('publish')
        ;

        $this->service->execute($this->journey);
    }

    public function testCarNotFoundAndNotAssign(): void
    {

        $this->carRepository->expects(static::once())
            ->method('findAvailableCar')
            ->willReturn(null)
        ;

        $this->journeyRepository->expects(static::never())
            ->method('update')
        ;

        $this->journey->expects(static::never())
            ->method('assignCar')
        ;

        $this->publisher->expects(static::never())
            ->method('publish')
        ;

        $this->service->execute($this->journey);
    }

}