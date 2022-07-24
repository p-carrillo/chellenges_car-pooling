<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Command\Journey\RequestJourney;

use App\CarPooling\Application\Command\Journey\RequestJourney\RequestJourneyCommand;
use App\CarPooling\Application\Command\Journey\RequestJourney\RequestJourneyHandler;
use App\CarPooling\Application\Service\CarPool\AssignGroupToCarIfAvailableService;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use App\Classroom\Application\Exception\Student\StudentDoesNotBelongInAcademyException;
use PHPUnit\Framework\TestCase;

class RequestJourneyHandlerTest extends TestCase
{
    private JourneyRepositoryInterface $repository;
    private AssignGroupToCarIfAvailableService $service;
    private RequestJourneyHandler $handler;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(JourneyRepositoryInterface::class);
        $this->service = $this->createMock(AssignGroupToCarIfAvailableService::class);
        $this->handler = new RequestJourneyHandler(
            $this->repository,
            $this->service,
        );
    }

    public function testJourneyFoundAndAssignWorks(): void
    {
        $command = $this->generateCommand();

        $this->repository->expects(static::once())
            ->method('getOneById')
            ->willReturn(Journey::create(1,4))
        ;

        $this->service->expects(static::once())
            ->method('execute')
        ;

        $this->handler->handle($command);
    }

    public function testJourneyNotFoundCreatesJourney(): void
    {
        $command = $this->generateCommand();

        $this->repository->expects(static::once())
            ->method('getOneById')
            ->willReturn(null)
        ;

        $this->repository->expects(static::once())
            ->method('create')
        ;

        $this->service->expects(static::once())
            ->method('execute')
        ;

        $this->handler->handle($command);
    }

    private function generateCommand(): RequestJourneyCommand
    {
        return new RequestJourneyCommand(
            1,2
        );
    }

}