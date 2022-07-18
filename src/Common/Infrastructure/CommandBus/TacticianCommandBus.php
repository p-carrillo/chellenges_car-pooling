<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\CommandBus;

use App\Common\Application\CommandBus\CommandBusInterface;
use App\Common\Application\CommandBus\CommandInterface;
use League\Tactician\CommandBus;

class TacticianCommandBus implements CommandBusInterface
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle(CommandInterface $command)
    {
        return $this->bus->handle($command);
    }
}
