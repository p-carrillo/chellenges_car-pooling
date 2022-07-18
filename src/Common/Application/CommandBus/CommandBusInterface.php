<?php

declare(strict_types=1);

namespace App\Common\Application\CommandBus;

interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}
