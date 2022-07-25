<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Command\Journey\RequestLocation;

use App\CarPooling\Application\Command\Journey\RequestLocation\RequestLocationCommand;
use App\CarPooling\Application\Command\Journey\RequestLocation\RequestLocationHandler;
use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarView;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestLocationHandlerTest extends TestCase
{
    private JourneyRepositoryInterface $repository;
    private RequestLocationHandler $handler;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(JourneyRepositoryInterface::class);
        $this->journey = $this->createMock(Journey::class);
        $this->car = $this->createMock(Car::class);
        $this->handler = new RequestLocationHandler(
            $this->repository
        );
    }

    public function testJourneyFoundAndAssignWorks(): void
    {
        $command = $this->generateCommand();
        $expectedResult = CarView::create(1,2);

        $car = Car::create(1,2);
        $journey = Journey::create(1,4);
        $journey->assignCar($car);

        $this->repository->expects(static::once())
            ->method('getOneById')
            ->willReturn($journey)
        ;

        $result = $this->handler->handle($command);
        self::assertEquals($result, $expectedResult);
    }

    public function testJourneyNotFoundThrowsException(): void
    {
        $command = $this->generateCommand();

        $this->repository->expects(static::once())
            ->method('getOneById')
            ->willReturn(null)
        ;

        $this->expectException(NotFoundHttpException::class);
        $this->handler->handle($command);
    }

    private function generateCommand(): RequestLocationCommand
    {
        return new RequestLocationCommand(
            1
        );
    }

}