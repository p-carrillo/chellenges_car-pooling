<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\QueryBus;

use App\Common\Application\QueryBus\QueryBusInterface;
use App\Common\Application\QueryBus\QueryInterface;
use League\Tactician\CommandBus;

class TacticianQueryBus implements QueryBusInterface
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function query(QueryInterface $query)
    {
        return $this->bus->handle($query);
    }
}
