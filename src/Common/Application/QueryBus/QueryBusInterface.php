<?php

declare(strict_types=1);

namespace App\Common\Application\QueryBus;

interface QueryBusInterface
{
    public function query(QueryInterface $query);
}
