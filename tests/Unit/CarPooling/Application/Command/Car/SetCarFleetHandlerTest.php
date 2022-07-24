<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Command\Car;

use App\CarPooling\Application\Command\Car\SetCarFleet\SetCarFleetCommand;
use App\CarPooling\Application\Command\Car\SetCarFleet\SetCarFleetHandler;
use App\CarPooling\Application\Service\CarPool\ResetApplicationService;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use PHPUnit\Framework\TestCase;

class SetCarFleetHandlerTest extends TestCase
{
    private CarRepositoryInterface $repository;
    private ResetApplicationService $resetApplicationService;
    private SetCarFleetHandler $setCarFleetHandler;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(CarRepositoryInterface::class);
        $this->resetApplicationService = $this->createMock(ResetApplicationService::class);
        $this->handler = new SetCarFleetHandler(
            $this->repository,
            $this->resetApplicationService,
        );
    }

    public function testCarFleetWorks(): void
    {
        $command = $this->generateCommand();

        $this->repository->expects(static::once())
            ->method('loadCarFleet')
        ;

        $this->resetApplicationService->expects(static::once())
            ->method('execute')
        ;

        $this->handler->handle($command);
    }

    private function generateCommand(): SetCarFleetCommand
    {
        return new SetCarFleetCommand(
            []
        );
    }

}