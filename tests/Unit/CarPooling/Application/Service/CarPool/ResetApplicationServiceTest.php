<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Service\CarPool;

use App\CarPooling\Application\Service\CarPool\ResetApplicationService;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ResetApplicationServiceTest extends TestCase
{
    private CarRepositoryInterface $carRepository;
    private JourneyRepositoryInterface $journeyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->carRepository = $this->createMock(CarRepositoryInterface::class);
        $this->journeyRepository = $this->createMock(JourneyRepositoryInterface::class);
        $this->service = new ResetApplicationService(
            $this->carRepository,
            $this->journeyRepository,
        );
    }

    public function testCarFoundAndPeopleDropped(): void
    {
        $this->journeyRepository->expects(static::once())
            ->method('reset')
        ;

        $this->carRepository->expects(static::once())
            ->method('reset')
        ;

        $this->service->execute();
    }

}