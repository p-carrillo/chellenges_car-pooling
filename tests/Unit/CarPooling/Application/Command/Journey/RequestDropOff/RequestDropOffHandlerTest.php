<?php

declare(strict_types=1);

namespace App\Tests\Unit\CarPooling\Application\Command\Journey\RequestDropOff;

use App\CarPooling\Application\Command\Journey\RequestDropOff\RequestDropOffCommand;
use App\CarPooling\Application\Command\Journey\RequestDropOff\RequestDropOffHandler;
use App\CarPooling\Application\Service\CarPool\DropOffGroupService;
use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequestDropOffHandlerTest extends TestCase
{
    private JourneyRepositoryInterface $repository;
    private DropOffGroupService $service;
    private RequestDropOffHandler $handler;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(JourneyRepositoryInterface::class);
        $this->service = $this->createMock(DropOffGroupService::class);
        $this->handler = new RequestDropOffHandler(
            $this->repository,
            $this->service,
        );
    }

    public function testRequestDropOffWorks(): void
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

    public function testJourneyNotFoundThrowsException(): void
    {
        $command = $this->generateCommand();

        $this->repository->expects(static::once())
            ->method('getOneById')
            ->willReturn(null)
        ;

        $this->service->expects(static::never())
            ->method('execute')
        ;
        $this->expectException(NotFoundHttpException::class);
        $this->handler->handle($command);
    }

    private function generateCommand(): RequestDropOffCommand
    {
        return new RequestDropOffCommand(
            1
        );
    }

}