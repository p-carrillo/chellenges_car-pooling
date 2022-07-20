<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Car\SetCarFleet;

class SetCarFleetHandler
{
    public function handle(SetCarFleetCommand $command): void
    {
        dump('ola k ase');
        dump($command->carFleet());
        die;
    }
}