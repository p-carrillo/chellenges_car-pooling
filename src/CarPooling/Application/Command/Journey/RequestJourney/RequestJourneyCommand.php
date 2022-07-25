<?php

declare(strict_types=1);

namespace App\CarPooling\Application\Command\Journey\RequestJourney;

class RequestJourneyCommand
{
    private int $id;
    private int $people;

    public function __construct(
        int $id,
        int $people,
    ) {
        $this->id = $id;
        $this->people = $people;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function people(): int
    {
        return $this->people;
    }
}